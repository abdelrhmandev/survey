<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class PlayerResource extends JsonResource
{
    public function toArray($request)
    {

       
        $customClaims = [
            'sub'                => 'PlayerGameInfo',
            // 'player_id'          => '1',
            'player_name'        => $request->name,
            'game_id'            =>$this->game->id,
            'game_type_slug'     =>$this->game->type->slug,
            'isteam'             =>$this->game->play_with_team,
            'color'              =>$this->game->color,
            'exp'                => strtotime('+ 1 days'), // One Day From creation
        ];
        $payload = JWTFactory::customClaims($customClaims)->make();
        $token = JWTAuth::encode($payload, 'HS256');


        return [
            '_token'             => $token->get(),
            'token_type'         => 'bearer',
            'game_id'            =>$this->game->id,
            'game_type_slug'     =>$this->game->type->slug,
            'isteam'             =>$this->game->play_with_team,
            'color'              =>$this->game->color,
        ];
    }
}
