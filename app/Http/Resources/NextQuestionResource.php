<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\ApiFunctions;

class NextQuestionResource extends JsonResource
{
    use ApiFunctions;

    public function __construct($resource, $Qtitle)
    {
        // Ensure you call the parent constructor
        parent::__construct($resource);
        $this->resource = $resource;
        
        $this->Qtitle = $Qtitle;
    }

    public function toArray($request)
    {
        return [
            'answer_id'            => $this->id,
            'answer_title'         => $this->title,
        ];
    }
}
