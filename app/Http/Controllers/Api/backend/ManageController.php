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
            $query = Game::select(['id', 'user_id','status', 'slug', 'type_id', 'pin', 'image', 'color', 'event_end_date'])
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
                } else if ($game->status !== 'closed') {
                    // Open Game
                    $game_id = $game->id;
                    $OpenGame = Game::where(['id' => $game_id])->update(['status' => 'opened']);
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
                } else {
                    return $this->returnError('401', 'Game Maybe Closed or not applicable to play');
                }
            } else {
                return $this->returnError('401', 'Unauthorized Game Owner');
            }
        }
    }

    public function NextQuestion(Request $request)
    {
        $token = request()->bearerToken();
        $game_id = $this->decodeToken($token, 'game_id');

        $query = Game::select(['id', 'user_id', 'type_id'])
            ->with([
                'type' => function ($query) {
                    $query->select('id', 'slug');
                },
            ])
            ->where('id', $game_id)
            ->first();

        /////////////////////////////////////////TRUE CASE //////////////////////////////////////////////////

        if ($request->get_next_question == 'true') {
            $checkIfOpenedQuestion = GameQuestion::where('game_id', $query->id)
                ->where('status', 'opened')
                ->count();

            $remaining_questions_master = GameQuestion::where('game_id', $query->id)
                    ->where('status', 'pending')
                    ->count();
                    
            if ($checkIfOpenedQuestion > 0 ){
                $OpenedQuestion = GameQuestion::with(['question'])
                    ->where('game_id', $query->id)
                    ->where('status', 'opened')
                    ->orderBy('order', 'asc')
                    ->first();
                if (isset($OpenedQuestion->question_id)) {
                    $clsoeCurrentQuestion = GameQuestion::where(['question_id' => $OpenedQuestion->question_id, 'game_id' => $query->id])->update(['status' => 'closed']);
                    
                    }
                
                if ($remaining_questions_master > 0) {
                    // handle Next Question
                    $getNextQuestion = GameQuestion::where('status', 'pending')
                        ->where('game_id', $query->id)
                        ->orderBy('order', 'asc')
                        ->first();
                    if (isset($getNextQuestion->question_id)) {
                        $OpenNextQuestion = GameQuestion::where(['question_id' => $getNextQuestion->question_id, 'game_id' => $query->id])->update(['status' => 'opened']);
                        $getNextQuestiondata = GameQuestion::where(['question_id' => $getNextQuestion->question_id, 'game_id' => $query->id])->first();
                    } else {
                        return $this->returnError('there is no next question available', 404);
                    }

                    // Respose variables

                    $QID = $getNextQuestiondata->question->id;

                    $Q_title = $getNextQuestiondata->question->title;

                    $correct_answer_id = $getNextQuestiondata->question->correctAnswer->correct_answer_id;

                    $answers = Answer::where('question_id', $QID);
                    $remaining_questions = GameQuestion::where('game_id', $query->id)
                        ->where('status', 'pending')
                        ->count();

                    $question_time = $getNextQuestiondata->question->time;

                    $date = date_create(date('H:i:s'));
                    date_add($date, date_interval_create_from_date_string($question_time . ' seconds'));

                    $end_time = date('H:i:s', strtotime("+$question_time sec"));

                    if (
                        GameQuestion::where(['question_id' => $QID, 'game_id' => $query->id])->update([
                            'status' => 'opened',
                            'start_time' => date('H:i:s'),
                            'end_time' => $end_time,
                        ])
                    ) {
                        $data = NextQuestionResource::collection($answers->get());

                        return $this->returnAnswersData(200, 'Answers listing', ['question_title' => $Q_title, 'correct_answer_id' => $correct_answer_id, 'remaining_questions' => $remaining_questions, 'counter' => $answers->count(), 'answers' => $data]);
                    }
                    
            }else{
                return $this->returnAnswersData(200, 'Answers listing', ['question_title' => 'No Question Available', 'remaining_questions' => $remaining_questions_master]);
            }
                
            } else if($remaining_questions_master > 0) {
                $PendingQ = GameQuestion::where('game_id', $query->id)
                    ->where('status', 'pending')
                    ->orderBy('order', 'asc')
                    ->first();

                $QID = $PendingQ->question->id;
                $Q_title = $PendingQ->question->title;
                $correct_answer_id = $PendingQ->question->correctAnswer->correct_answer_id;
                $answers = Answer::where('question_id', $QID);
                $remaining_questions = GameQuestion::where('game_id', $query->id)
                    ->where('status', 'pending')
                    ->count();

                $question_time = $PendingQ->question->time;
                $date = date_create(date('H:i:s'));

                $end_time = date('H:i:s', strtotime("+$question_time sec"));

                if (
                    GameQuestion::where(['question_id' => $QID, 'game_id' => $query->id])->update([
                        'status' => 'opened',
                        'start_time' => date('H:i:s'),
                        'end_time' => $end_time,
                    ])
                ) {
                    $data = NextQuestionResource::collection($answers->get());
                    return $this->returnAnswersData(200, 'Answers listing', ['question_title' => $Q_title, 'correct_answer_id' => $correct_answer_id, 'remaining_questions' => $remaining_questions, 'counter' => $answers->count(), 'answers' => $data]);
                }
            }else{
                return $this->returnAnswersData(200, 'Answers listing', ['question_title' => 'No Question Available','remaining_questions' => $remaining_questions_master]);
            }

            /////////////////////////////////FALSE CASE /////////////////////////////////////////
        } elseif ($request->get_next_question == 'false') {
            $OQ = GameQuestion::where('game_id', $query->id)
                ->where('status', 'opened')
                ->orderBy('order', 'asc')
                ->first();

            if ($OQ) {
                $QID = $OQ->question->id;
                $Q_title = $OQ->question->title;
                $correct_answer_id = $OQ->question->correctAnswer->correct_answer_id;
                $answers = Answer::where('question_id', $QID);
                $remaining_questions = GameQuestion::where('game_id', $query->id)
                    ->where('status', 'pending')
                    ->count();
                $data = NextQuestionResource::collection($answers->get());
                return $this->returnAnswersData(200, 'Answers listing', ['question_title' => $Q_title, 'correct_answer_id' => $correct_answer_id, 'remaining_questions' => $remaining_questions, 'counter' => $answers->count(), 'answers' => $data]);
            } else {
                return $this->returnError('there is no question here', 404);
            }
        }
    }

    public function Winnerslist()
    {
        $token = request()->bearerToken();
        $game_id = $this->decodeToken($token, 'game_id');
        // $user_id = 1;
        $query = Game::select(['id', 'user_id', 'play_with_team'])
            ->with([
                'type' => function ($query) {
                    $query->select('id', 'slug');
                },
            ])
            ->where('id', $game_id)
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

        Game::where(['id' => $game_id])->update(['status' => 'closed']);
        return $this->returnData('data', $data, 200, $k);
    }
}
