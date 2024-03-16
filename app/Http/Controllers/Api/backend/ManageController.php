<?php
namespace App\Http\Controllers\Api\backend;

use App\Models\Game;
use App\Models\Answer;
use App\Models\Player;
use App\Models\GameTeam;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use App\Models\GameQuestion;
use App\Traits\ApiFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PlayerSubmittedAnswer;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\WinnerTeamResource;
use App\Http\Resources\NextQuestionResource;
use App\Http\Resources\WinnerPlayerResource;

class ManageController extends Controller
{
    use ApiFunctions;

    public function CheckgameAuthor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
            'game_slug' => 'required|string|exists:games,slug',
        ]);
        $credentials = $request->only('username', 'password');
        if ($validator->fails()) {
            return $this->returnError('400', $validator->errors());
        } else {
            $validateUser = Auth::guard('admin')->attempt($credentials);

            if (!$validateUser) {
                return $this->returnError('401', 'Unauthorized , Invalid credentials');
            }

            $AdminUserInfo = Auth::guard('admin');
            $user_id = $AdminUserInfo->user()->id;
            $game_slug = $request->game_slug;
            $query = Game::select(['id', 'user_id', 'slug', 'type_id', 'pin', 'image', 'color', 'event_end_date'])
                ->with([
                    'type' => function ($query) {
                        $query->select('id', 'slug');
                    },
                ])
                ->where('user_id', $user_id)
                ->whereSlug($game_slug);

            if ($query->exists()) {
                $game = $query->first();

                if ($game->event_end_date < date('Y-m-d')) {
                    return $this->returnError('400', 'Game Event has been Expired [' . \Carbon\Carbon::parse($game->event_end_date)->diffForHumans() . ']');
                } else {
                    $customClaims = [
                        'sub' => 'Admininfo',
                        'name' => $AdminUserInfo->user()->name,
                        'email' => $AdminUserInfo->user()->email,
                        'game_id' => $game->id,
                        'user_id' => $user_id,
                        'exp' => strtotime('+ 1 days'), // One Day From creation
                    ];
                    $payload = JWTFactory::customClaims($customClaims)->make();
                    $token = JWTAuth::encode($payload, 'HS256');
                    $data = [
                        'game_url' => 'https://game.invent.solutions/playergame/' . $game->slug,
                        'game_type_slug' => $game->type->slug,
                        'event_logo' => $game->image ? url(asset($game->image)) : '',
                        'pin_code' => $game->pin,
                        'event_color' => $game->color,
                        '_token' => $token->get(),
                        'token_type' => 'bearer',
                    ];
                    return $this->returnData('data', $data, 200, 'Game Info' . $game->title);
                }
            } else {
                return $this->returnError('401', 'Unauthorized Game Owner');
            }
        }
    }

    public function NextQuestion(Request $request)
    {
        $token = request()->bearerToken();
        $user_id = $this->decodeToken($token, 'user_id');

        $query = Game::select(['id', 'user_id', 'type_id'])
            ->with([
                'type' => function ($query) {
                    $query->select('id', 'slug');
                },
            ])
            ->where('user_id', $user_id)
            ->first();

        $question_id = $query->nextQuestion->first()->pivot->question_id;
        $question_time = $query->nextQuestion->first()->time;
        $correct_answer_id = $query->nextQuestion->first()->answers->first()->id;
        $Qtitle = $query->nextQuestion->first()->title;

        $answers = Answer::where('question_id', $question_id);

        $remaining_questions = GameQuestion::where('game_id', $query->id)
            ->where('question_id', '<>', $question_id)
            ->count();

        if (
            GameQuestion::where('game_id', $query->id)
                ->where('status', 'opened')
                ->count() > 0
        ) {
            
            $OpenedQuestion= GameQuestion::where('game_id', $query->id)->where('status', 'opened')->orderBy('order', 'asc')->first();
            
            
              $Qtitle = $OpenedQuestion->question->title;
        

            if(GameQuestion::where(['question_id' => $OpenedQuestion->question_id, 'game_id' => $query->id])
            ->update(['status' => 'closed'])){
        
                dd('OK');
            }

            $NextQuestion = GameQuestion::where('status', 'pending')
                ->where('game_id', '=', $query->id)
                ->orderBy('order', 'asc')
                ->first();

             
        }

        $date = date_create(date('H:i:s')); //create a date/time variable (with the specified format - create your format, see (1))
        date_add($date, date_interval_create_from_date_string($question_time . ' seconds')); //add dynamic quantity of seconds to data/time variable
        $end_time = date_format($date, 'H:i:s'); //shows the new data/time value
        $end_time = date('H:i:s', strtotime("+$question_time sec"));

        GameQuestion::where(['question_id' => $question_id, 'game_id' => $query->id])->update([
            'status' => 'opened',
            'start_time' => date('H:i:s'),
            'end_time' => $end_time,
        ]);

        $data = NextQuestionResource::collection($answers->get());

        return $this->returnAnswersData(200, 'Answers listing', ['question_title' => $Qtitle, 'correct_answer_id' => $correct_answer_id, 'remaining_questions' => $remaining_questions, 'counter' => $answers->count(), 'answers' => $data]);
    }

    public function Winnerslist()
    {
        $user_id = 1;
        $query = Game::select(['id', 'user_id', 'play_with_team'])
            ->with([
                'type' => function ($query) {
                    $query->select('id', 'slug');
                },
            ])
            ->where('user_id', $user_id)
            ->first();

        if ($query->play_with_team == 1) {
            $TeamPlayers = PlayerSubmittedAnswer::with('team')
                ->groupBy('game_team_id')
                ->where('game_id', $query->id)
                ->select('game_team_id', DB::raw('SUM(score) as total_team_score'))
                ->orderBy('total_team_score', 'DESC');
            $data = WinnerTeamResource::collection($TeamPlayers->get());

            $k = 'Winners Teams';
        } else {
            $Players = PlayerSubmittedAnswer::with('player')
                ->groupBy('player_id')
                ->where('game_id', $query->id)
                ->select('player_id', DB::raw('SUM(score) as total_player_score'))
                ->orderBy('total_player_score', 'DESC');
            $data = WinnerPlayerResource::collection($Players->get());
            $k = 'Winners Players';
        }

        return $this->returnData('data', $data, 200, $k);
    }
}
