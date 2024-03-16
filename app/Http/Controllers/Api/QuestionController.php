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
    public function playerQuestion(Request $request)
    {


        $token          = request()->bearerToken();
        $game_id        = $this->decodeToken($token,'game_id');
        $game_title     = $this->decodeToken($token,'game_title');
        $player_id      = $this->decodeToken($token,'player_id');


        $GameQuestion = GameQuestion::with('question')->where('status','opened')->where('game_id', $game_id)->first();        


        $isSubmitted = PlayerSubmittedAnswer::where(['player_id'=>$player_id,'game_id'=>$game_id,'question_id'=>$GameQuestion->question_id])->exists() ? true:false;

        if ($GameQuestion) {       
            return $this->returnQData('data', new QuestionResource($GameQuestion,$isSubmitted), 200, 'Game Question');
        } else {
            return $this->returnNoQData(new QuestionResource($GameQuestion));
        }
    }

 
}
