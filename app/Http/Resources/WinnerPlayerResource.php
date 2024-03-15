<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\ApiFunctions;

class WinnerPlayerResource extends JsonResource
{
    use ApiFunctions;
    public function toArray($request)
    {
        return [
            'winner_name'        => $this->player->name,
            'winner_score'       => $this->total_player_score,
        ];
    }
}
