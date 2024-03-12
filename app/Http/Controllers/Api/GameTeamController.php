<?php
namespace App\Http\Controllers\Api;
use App\Models\Game;
use App\Models\Player;
use App\Models\GameTeam;
use App\Traits\ApiFunctions;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Http\Resources\TeamResource;
use App\Http\Resources\PlayerResource;
use App\Http\Resources\GameSlugResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TeamPlayerResource;

class GameTeamController extends Controller
{
    use ApiFunctions;

    protected $player;
 
    public function __construct()
    {
        $this->player = JWTAuth::parseToken()->authenticate();
    }



    /////////////////// API 3 ///////////////////////////////////////
    public function getTeamsByGameId(Request $request){
      
   
        $token = request()->bearerToken();

      
 
        $game_id = ($this->decodeToken($token,'game_id'));
        $game_title = ($this->decodeToken($token,'game_title'));
        $player_id = ($this->decodeToken($token,'player_id'));
       
         if(Player::where('id',$player_id)->first()->game_team_id){
            $has_team = 'true';
         }else{
            $has_team = 'false';
         }


        $gameTeams = GameTeam::select(['id','game_id', 'team_title', 'capacity'])->where('game_id', $game_id);
        $data = TeamResource::collection($gameTeams->get());

        return $this->returnMultiTeamsData('data', $data, 200, 'Team listings in Game ' . $game_title . '', $has_team);
    }
    /////////////////////////////////////////////////////////////



}
