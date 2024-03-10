<?php

namespace App\Http\Resources;
use App\Models\QuestionCorrectAnswer;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerSubmittedAnswerResource extends JsonResource
{
    public function toArray($request)
    {

       
        return [
            'question_id'              =>$this->question_id,
            'correct_answer_id'        => QuestionCorrectAnswer::select('question_id','correct_answer_id')->where('question_id',$this->question_id)->first()->correct_answer_id,
        ];
    }
}
