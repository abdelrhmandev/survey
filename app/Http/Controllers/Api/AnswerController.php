<?php
namespace App\Http\Controllers\Api;
use App\Models\Question;

use App\Models\GameQuestion;
use App\Traits\ApiFunctions;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\PlayerSubmittedAnswer;
use App\Models\QuestionCorrectAnswer;
use Tymon\JWTAuth\Facades\JWTFactory;
use App\Http\Resources\QuestionResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PlayerSubmittedAnswerResource;

class QuestionController extends Controller
{


    
    protected $player;
 
    public function __construct()
    {
        $this->player = JWTAuth::parseToken()->authenticate();
    }


    use ApiFunctions;
    

    public function playerPostAnswer(Request $request)
    {


        $token          = request()->bearerToken();
        $game_id        = $this->decodeToken($token,'game_id');
        $game_title     = $this->decodeToken($token,'game_title');
        $player_id      = $this->decodeToken($token,'player_id');

        $question_id    = $request->question_id;
        $answer_id      = $request->answer_id;



        $validator = Validator::make($request->all(), [
            'game_team_id' => 'required|exists:game_teams,id',
            'question_id'  => 'required|exists:questions,id',            
            'answer_id'    => 'required|exists:answers,id',
        ]);
        if ($validator->fails()) {
            return $this->returnError('400', $validator->errors());
        }

            $data = [
                'game_id'     => $game_id,
                'player_id'   => $player_id,
                'question_id' => $question_id,
                'answer_id'   => $answer_id,    
            ];

            $PlayerSubmittedAnswer = PlayerSubmittedAnswer::create($data);

            $remaining_questions = GameQuestion::where('game_id',$game_id)->where('question_id','<>',$question_id)->count();
            if($PlayerSubmittedAnswer){
                return $this->returnPlayerSubmitData('data', new PlayerSubmittedAnswerResource($PlayerSubmittedAnswer), 201, 'answer has been submitted successfully',$remaining_questions);
             }else{
                return $this->returnError('400', 'erro save answer');
             }


    }
}
