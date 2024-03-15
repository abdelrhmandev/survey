<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\ApiFunctions;

class WinnerTeamResource extends JsonResource
{
    use ApiFunctions;
    public function toArray($request)
    {
        return [
            'winner_name'        => $this->team->team_title,
            'winner_score'       => $this->total_team_score,
        ];
    }
}
