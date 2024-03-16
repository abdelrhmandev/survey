<?php

namespace App\Http\Resources;
use App\Models\GameQuestion;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{

    public function __construct($resource, $isSubmitted)
    {
        // Ensure you call the parent constructor
        parent::__construct($resource);
        $this->resource = $resource;
        
        $this->isSubmitted = $isSubmitted;
    }


    public function toArray($request)
    {
        return [
            'isSubmitted'         => $this->isSubmitted,
            'question_id'         => $this->question->id,
            'remaining_questions' => GameQuestion::where('status','pending')->where('game_id',$this->game_id)->where('id','<>',$this->question_id)->count(),
            'question_title'      => $this->question->title,            
            'question_start_time' => $this->start_time,
            'question_end_time'   => $this->end_time,
            'question_brand'      => $this->question->brand->title,
            'correct_answer_id'   => $this->question->correctAnswer->correct_answer_id,
            'answers'             => $this->question->answers->select('id','title')
        ];
    }
}
