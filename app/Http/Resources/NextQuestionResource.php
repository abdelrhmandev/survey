<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\ApiFunctions;

class NextQuestionResource extends JsonResource
{
    use ApiFunctions;
    public function toArray($request)
    {
        return [
            'answer_id'            => $this->id,
            'answer_title'         =>$this->title,
        ];
    }
}
