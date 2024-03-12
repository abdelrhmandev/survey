<?php
namespace App\Http\Controllers\Api;
use App\Models\Player;

use App\Models\GameTeam;
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
use App\Http\Resources\TeamPlayerResource;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Resources\PlayerSubmittedAnswerResource;

class PlayerTeamController extends Controller
{


    
    protected $player;
 
    public function __construct()
    {
        $this->player = JWTAuth::parseToken()->authenticate();
    }


    use ApiFunctions;

    public function playerTeam(Request $request)
    {

        $token          = request()->bearerToken();
        $game_team_id  = $request->game_team_id;     

        $token          = request()->bearerToken();
        $game_id        = $this->decodeToken($token,'game_id');
        $game_title     = $this->decodeToken($token,'game_title');
        $player_id      = $this->decodeToken($token,'player_id');


        
        // dd($request->player_token);
        $validator = Validator::make($request->all(), [
            'game_team_id' => 'required|exists:game_team,id',
        ]);
        if ($validator->fails()) {
            return $this->returnError('400', $validator->errors());
        }
        $query = GameTeam::where(['id'=>$game_team_id,'game_id'=>$game_id])->first();
        $data = new TeamPlayerResource($query);
         
        if($this->checkJoinTeam($game_id,$game_team_id) < $query->capacity){           
            Player::where(['id'=>$player_id,'game_id'=>$game_id])->update(['game_team_id'=>$game_team_id]);
        }
        return $this->returnData('data', $data, 200, 'Game Team Info');
    }
 
}
