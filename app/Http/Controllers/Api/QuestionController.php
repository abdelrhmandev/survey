<?php
namespace App\Http\Controllers\Api;
use App\Models\Question;

use App\Models\GameQuestion;
use App\Traits\ApiFunctions;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

use Tymon\JWTAuth\Facades\JWTFactory;
use App\Http\Resources\QuestionResource;
use Illuminate\Support\Facades\Validator;

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
}
