<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class TeamResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'team_id'             => $this->id,
            'team_title'          => $this->team_title,
            'is_enabled'          => $this->capacity == 0 ? false:true,
        ];
    }
}
