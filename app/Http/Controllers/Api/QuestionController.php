<?php
namespace App\Http\Controllers\Api;
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
use App\Http\Resources\PlayerSubmittedAnswerResource;

class QuestionController extends Controller
{
    use ApiFunctions;
    public function playerQuestion(Request $request)
    {
        $token = $request->player_token;

        $tokenParts = explode('.', $token);
        $tokenHeader = base64_decode($tokenParts[0]);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtHeader = json_decode($tokenHeader);
        $jwtPayload = json_decode($tokenPayload);
        $game_id = $jwtPayload->game_id;
        // $player_id     = $jwtPayload->player_id;
        $player_name = $jwtPayload->player_name;
        $expDate = $jwtPayload->exp;
        $question = GameQuestion::whereHas('GetPlayerOpenedQuestion')->where('game_id', $game_id)->first();        
        if ($question) {        
            return $this->returnQData('data', new QuestionResource($question), 200, 'Game Question');
        } else {
            return $this->returnNoQData(new QuestionResource($question));
        }
    }

    public function playerPostAnswer(Request $request)
    {

        
        $game_id = ($this->decodeToken($request->player_token,'game_id'));
        $game_title = ($this->decodeToken($request->player_token,'game_title'));
        $player_id = ($this->decodeToken($request->player_token,'player_id'));



       
        $question_id = $request->question_id;
        $answer_id = $request->answer_id;



        $validator = Validator::make($request->all(), [
            'question_id' => 'required|exists:questions,id',
            'answer_id' => 'required|exists:answers,id',
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
