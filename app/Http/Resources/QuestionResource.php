<?php

namespace App\Http\Resources;
use App\Models\GameQuestion;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'question_id'         => $this->getQuestion->id,
            'remaining_questions' => GameQuestion::where('game_id',$this->game_id)->where('id','<>',$this->question_id)->count(),
            'question_title'      => $this->getQuestion->title,            
            'question_start_time' => $this->start_time,
            'question_end_time'   => $this->end_time,
            'question_brand'      => $this->getQuestion->brand->title,
            'correct_answer_id'   => $this->getQuestion->correctAnswer->id,
            'answers'             => $this->getQuestion->answers->select('id','title')
        ];
    }
}
