<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\ApiFunctions;
class TeamPlayerResource extends JsonResource
{
    use ApiFunctions;
    
    public function toArray($request)
    {
        return [
            'game_team_id'        => $this->id,
            'team_title'          => $this->team_title,
            'is_enabled_to_join'  => $this->capacity == $this->checkJoinTeam($this->id,$this->game_id) ? 'false':'true',                      
        ];
    }
}
