<?php
namespace App\Http\Controllers\Api;
use App\Models\Game;
use App\Models\Player;
use App\Models\GameTeam;
use App\Traits\ApiFunctions;
use Illuminate\Http\Request;
use App\Events\PlayerJoined;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use App\Http\Resources\TeamResource;
use Tymon\JWTAuth\Facades\JWTFactory;
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
        // if ($query->play_with_team == 1) {
            $player = Player::create([
                'name' => $request->name,
                'game_id' => $query->id,
            ]);
            if ($player) {

                $EventArr = [
                    'player_name'    =>str_replace(' ','-', $request->name),                    
                ];
                event(new PlayerJoined($EventArr));
                
                return $this->returnData('data', new PlayerResource($player), 201, 'player has been created successfully');
            }
        // } 
        // else {
        //     return $this->returnError('400', 'this game is not played with a team , try other game');
        // }
    }
}
