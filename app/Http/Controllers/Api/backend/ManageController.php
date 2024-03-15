<?php
namespace App\Http\Controllers\Api\backend;

use App\Models\Game;
use App\Models\Answer;
use App\Models\Player;
use App\Models\GameTeam;
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

    public function CheckgameAuthor($slug, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('username', 'password');
        if ($validator->fails()) {
            return $this->returnError('400', $validator->errors());
        } else {
            $token = Auth::guard('admin')->attempt($credentials);
            if (!$token) {
                return $this->returnError('401', 'Unauthorized , Invalid credentials');
            }
            $AdminUserInfo = Auth::guard('admin');
            $user_id = $AdminUserInfo->user()->id;
            $query = Game::select(['id', 'user_id', 'type_id', 'pin', 'image', 'color', 'event_end_date'])
                ->with([
                    'type' => function ($query) {
                        $query->select('id', 'slug');
                    },
                ])
                ->where('user_id', $user_id)
                ->whereSlug($slug);
            if ($query->exists()) {
                $game = $query->first();
                if ($game->event_end_date < date('Y-m-d')) {
                    return $this->returnError('400', 'Game Event has been Expired [' . \Carbon\Carbon::parse($game->event_end_date)->diffForHumans() . ']');
                } else {
                    $data = [
                        'game_url' => route('CheckgameAuthor', ['slug' => $slug]),
                        'game_type_slug' => $game->type->slug,
                        'event_logo' => $game->image ? url(asset($game->image)) : '',
                        'pin_code' => '',
                        'pin_code' => $game->pin,
                        'event_color' => $game->color,
                    ];
                    return $this->returnData('data', $data, 200, 'Game Info ' . $game->title);
                }
            } else {
                return $this->returnError('401', 'Unauthorized Game Owner');
            }
        }
    }

    public function NextQuestion()
    {
        $user_id = 1;
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

        $remaining_questions = GameQuestion::where('game_id', $query->id)->where('question_id', '<>', $question_id)->count();
        $date = date_create(date('H:i:s')); //create a date/time variable (with the specified format - create your format, see (1))
        date_add($date, date_interval_create_from_date_string($question_time.' seconds')); //add dynamic quantity of seconds to data/time variable
        $end_time = date_format($date, 'H:i:s'); //shows the new data/time value
        $end_time =  date("H:i:s", strtotime("+$question_time sec"));
        GameQuestion::where(['question_id'=>$question_id,'game_id'=>$query->id])->update(['status'=>'opened','start_time'=>date('H:i:s'),'end_time'=>$end_time]);            
        $data = NextQuestionResource::collection($answers->get());
        return $this->returnAnswersData('data', $data, 200, 'Answers listing', $Qtitle, $correct_answer_id, $remaining_questions);
    }


    public function Winnerslist(){

 


        $user_id = 1;
        $query = Game::select(['id','user_id', 'play_with_team'])
            ->with([
                'type' => function ($query) {
                    $query->select('id', 'slug');
                },
            ])
            ->where('user_id', $user_id)
            ->first();          

            if($query->play_with_team == 1){
                $TeamPlayers = PlayerSubmittedAnswer::with('team')->groupBy('game_team_id')->where('game_id',$query->id)->select('game_team_id', DB::raw('SUM(score) as total_team_score'))->orderBy('total_team_score','DESC');
                $data = WinnerTeamResource::collection($TeamPlayers->get());
            }else{

                $Players = PlayerSubmittedAnswer::with('player')->groupBy('player_id')->where('game_id',$query->id)->select('player_id', DB::raw('SUM(score) as total_player_score'))->orderBy('total_player_score','DESC');
                $data = WinnerPlayerResource::collection($Players->get());
                
            }
                

                return $this->returnData('data', $data, 200, 'Winners Teams');
        
                


        
    }
}
