<?php
namespace App\Http\Requests\backend;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class GroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        ///MULTI Languages Inputs Validation///////////
        $id                       = $this->request->get('id') ? ',' . $this->request->get('id') : '';
        $rules['title']           = 'required|max:255|unique:groups,title'.$id;
        $rules['brand_id']        = 'required|exists:brands,id';
        $rules['question_id']     = 'required|array|min:1|exists:questions,id';
        return $rules; 

    }

 


 
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status'   => 'RequestValidation',
            'msg'      => $validator->errors()
        ]));
    }
    
}
