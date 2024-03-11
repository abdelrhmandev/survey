<?php

namespace App\Http\Resources;
use App\Models\GameQuestion;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'question_id'         => $this->GetPlayerOpenedQuestion->id,
            'remaining_questions' => GameQuestion::where('game_id',$this->game_id)->where('id','<>',$this->question_id)->count(),
            'question_title'      => $this->GetPlayerOpenedQuestion->title,            
            'question_start_time' => $this->GetPlayerOpenedQuestion->start_time,
            'question_end_time'   => $this->GetPlayerOpenedQuestion->end_time,
            'question_brand'      => $this->GetPlayerOpenedQuestion->brand->title,
            'correct_answer_id'   => $this->GetPlayerOpenedQuestion->correctAnswer->id,
            'answers'             => $this->GetPlayerOpenedQuestion->answers->select('id','title')
        ];
    }
}
