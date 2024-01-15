<?php
namespace App\Http\Requests\backend;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class UpdateUserRequest extends FormRequest
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

        $id = $this->request->get('id') ? ',' . $this->request->get('id') : '';

        $rules['name']      = 'required|string|max:255';

        $rules['email']     = 'required|string|max:255|email|unique:users,email'.$id;;
        $rules['roles']     = 'required|exists:roles,id';   



        $rules['country_id']     = 'required|exists:countries,id';  

        $rules['mobile']    = 'required|max:255|unique:users,mobile'.$id;; 
        $rules['avatar']    = 'nullable|max:1000|mimes:jpeg,bmp,png,gif'; // max size 1 MB  



        $rules['username']  = 'required|string|max:255|unique:users,username'.$id;;
 
        $rules['status']    = 'nullable|in:0,1';

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
