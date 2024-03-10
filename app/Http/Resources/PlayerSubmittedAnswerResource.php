<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerSubmittedAnswerResource extends JsonResource
{
    public function toArray($request)
    {

       
        return [
            'question_id'              =>$this->question_id,
        ];
    }
}
