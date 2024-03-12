<?php
namespace App\Http\Controllers\Api;
use App\Models\Game;

use App\Models\Question;
use App\Models\GameQuestion;

use App\Traits\ApiFunctions;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Models\PlayerSubmittedAnswer;
use App\Models\QuestionCorrectAnswer;
use Tymon\JWTAuth\Facades\JWTFactory;
use App\Http\Resources\QuestionResource;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Resources\PlayerSubmittedAnswerResource;

class AnswerController extends Controller
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
            'game_team_id' => 'nullable|exists:game_team,id',
            'question_id'  => 'required|exists:questions,id',            
            'answer_id'    => 'required|exists:answers,id',
        ]);
        if ($validator->fails()) {
            return $this->returnError('400', $validator->errors());
        }

            $getScore = QuestionCorrectAnswer::where(['question_id'=>$question_id,'correct_answer_id'=>$answer_id])->exists();
            $getScore ? $score = Question::where('id',$game_id)->first()->score : $score = 0;                
            $data = [
                'game_id'     => $game_id,
                'player_id'   => $player_id,
                'question_id' => $question_id,
                'answer_id'   => $answer_id,    
                'score'       => $score,    
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
