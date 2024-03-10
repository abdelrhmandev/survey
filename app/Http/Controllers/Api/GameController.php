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

class GameController extends Controller
{
    use ApiFunctions;

    ///////////////////API 1 ////////////////////////////////////////////////////////////
    public function gameInfoBySlug($slug){
        $query = Game::select(['id', 'title', 'type_id', 'status', 'image', 'color', 'play_with_team', 'event_start_date', 'event_end_date'])
            ->whereSlug($slug)
            ->with([
                'type' => function ($query) {
                    $query->select('id', 'slug');
                },
            ])
            ->first();
        if (!$query) {
            return $this->returnError('404', 'No game match this slug');
        }
        $data = new GameResource($query);
        return $this->returnData('data', $data, 200, 'Game Info '.$query->title);
    }

    ///////////////////API 2 ////////////////////////////////////////////////////////////

    public function gameCheckPin(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[\pL\s\-]+$/u',
            'pin' => 'required|exists:games,pin',
        ]);
        if ($validator->fails()) {
            return $this->returnError('400', $validator->errors());
        }
        $query = Game::select(['id', 'slug', 'play_with_team'])
            ->wherePin($request->pin)
            ->with([
                'type' => function ($query) {
                    $query->select('id', 'title', 'slug');
                },
            ])
            ->first();
        if ($query->play_with_team == 1) {
            $player = Player::create([
                'name' => $request->name,
                'game_id' => $query->id,
            ]);
            if ($player) {
                return $this->returnData('data', new PlayerResource($player), 201, 'player has been created successfully');
            }
        } else {
            return $this->returnError('400', 'this game is not played with a team , try other game');
        }
    }



    /////////////////// API 3 ///////////////////////////////////////
    public function getTeamsByGameId(Request $request){
      
        
        $game_id = ($this->decodeToken($request->player_token,'game_id'));
        $game_title = ($this->decodeToken($request->player_token,'game_title'));
        $player_id = ($this->decodeToken($request->player_token,'player_id'));
       
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

    public function playerTeam(Request $request)
    {

        $token         = $request->player_token;   
        $game_team_id  = $request->game_team_id;     
        $tokenParts    = explode(".", $token);  
        $tokenHeader   = base64_decode($tokenParts[0]);
        $tokenPayload  = base64_decode($tokenParts[1]);
        $jwtHeader     = json_decode($tokenHeader);
        $jwtPayload    = json_decode($tokenPayload);
        $game_id       = $jwtPayload->game_id;        
        // $player_id     = $jwtPayload->player_id;
        $player_name   = $jwtPayload->player_name;
        $expDate       = $jwtPayload->exp;

        // dd($request->player_token);
        $validator = Validator::make($request->all(), [
            'game_team_id' => 'required|exists:game_team,id',
        ]);
        if ($validator->fails()) {
            return $this->returnError('400', $validator->errors());
        }
        $query = GameTeam::where(['id'=>$game_team_id,'game_id'=>$game_id])->first();
        $data = new TeamPlayerResource($query);
         
        if($this->checkJoinTeam($game_team_id,$game_team_id) < $query->capacity){           
            Player::where(['name'=>$player_name,'game_id'=>$game_id])->update(['game_team_id'=>$game_team_id]);
        }
        return $this->returnData('data', $data, 200, 'Game Team Info');
    }

    ///////
}
