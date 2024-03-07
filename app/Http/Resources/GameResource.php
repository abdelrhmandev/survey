<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class GameResource extends JsonResource
{
    public function toArray($request)
    {
         
        return [
            'game_title'             => $this->title,
            'game_type_slug'         => $this->type->slug,
            'game_status'            => $this->status,
            'event_logo'             => $this->image ? url(asset($this->image)) : '',
        ];
        
    }
}
