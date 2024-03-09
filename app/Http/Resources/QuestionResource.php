<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class QuestionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'question_id'         => $this->GetPlayerOpenedQuestion->id,
            'question_title'      => $this->GetPlayerOpenedQuestion->title,            
            'question_start_time' => $this->GetPlayerOpenedQuestion->start_time,
            'question_end_time'   => $this->GetPlayerOpenedQuestion->end_time,
            'question_brand'      => $this->GetPlayerOpenedQuestion->brand->title,
            'correct_answer_id'   => $this->GetPlayerOpenedQuestion->correctAnswer->id,

        ];
    }
}
