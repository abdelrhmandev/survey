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
        return $this->returnData('game', $data, 200, 'Game Info '.$query->title);
    }

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
                return $this->returnData('PlayerGameInfo', new PlayerResource($player), 201, 'player has been created successfully');
            }
        } else {
            return $this->returnError('400', 'this game is not played with a team , try other game');
        }
    }


    
    public function getTeamsByGameId(Request $request){


        $token = $request->player_token;




        // $token = "eyJhbGciOiJSUzI1NiJ9.eyJyb2xlcyI6WyJST0xFX1VTRVIiXSwidXNlcm5hbWUiOiJqYWdhZHVAaHViaWktbmV0d29yay5jb20iLCJleHAiOjE1MzYxNTI0MDAsImlhdCI6MTUzNTU0NzYwMH0.B7gnfGdW1ijAIlo9xUI0DwkGaajQAQPBkRx4ChILXRNtpLdwgEl_9gvWdiidFbSXJseS8jslOfuAFUIWATmbNBoWVa3nc8SxkIrKI29xZuN6hB7R-63RH2BKsAVPsEjgTIJoqkkCrfrSum-_d3LEf36jcXqZb8M-GRKI477IwSDDwG_7YK5v0mu8N4TATXhN0tZGNYxp8Y27EI-g0Gmj9BIiobxnqVVoBWHN5J8d-UCrXRq94ifhEiQBxkG9r_eacMscB80n1VsiN2ouKH2kX-HRxRJmcgmydxvR7RcEW-P6koTxkaZJGO6mv7auSudTFlDENpwD4OD7gtn_wMUDS_OuN8WT7rZp8lwKY9f8J9fiGyq5J-8C_HmyjW-h8WhuJmTUaKhCZ-eLgDm4Vs2IQGYkHJEDFumnIZ607MAa1CW1ChAvurqvUqJ3G4TTN4wYqAHpSKz4y8SAMLjO91cedBPH6K5i9lh5htF-mW_htem7e5ornicU_djSccgHbxfXHQYTHCnqLp7-ONfl_p4nmhIEK0wcF0gkBXbIitzeTjy7C_uf_FV1sLPE5cY3PUP42DmHrG4PuXHLv_L1EjErkrpna7pChKA_TPeiZjqMcQoE70sZw8rr8KnRF2hpABdU_M2ZXOt_vF5-T8mLmKqs0LHxE089vVC3xsAh0mUr4FE";

        $tokenParts = explode(".", $token);  
        $tokenHeader = base64_decode($tokenParts[0]);
        $tokenPayload = base64_decode($tokenParts[1]);
        $jwtHeader = json_decode($tokenHeader);
        $jwtPayload = json_decode($tokenPayload);
        $game_id = $jwtPayload->game_id;
        
          

        $query = GameTeam::with([
            'game' => function ($query) {
                $query->select('id', 'title');
            },
        ])
            ->select(['game_id', 'team_title'])
            ->where('game_id', $game_id)
            ->first();
        if (!$query) {
            return $this->returnError('404', 'No game match this id');
        }

        $gameTeams = GameTeam::select(['id', 'team_title', 'capacity'])->where('game_id', $game_id);
        $data = TeamResource::collection($gameTeams->get());

        return $this->returnMultiData('teams', $data, 200, 'Team listings in Game ' . $query->game->title . '');
    }


    public function playerTeam(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'game_team_id' => 'required|exists:game_team,id',
        ]);
        if ($validator->fails()) {
            return $this->returnError('400', $validator->errors());
        }
        $query = GameTeam::findOrfail($request->game_team_id)->first();
        $data = new TeamPlayerResource($query);
        return $this->returnData('team_player', $data, 200, 'Game Team Info');
    }

    ///////
}
