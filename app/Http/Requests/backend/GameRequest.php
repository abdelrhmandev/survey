<?php
namespace App\Http\Requests\backend;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class GameRequest extends FormRequest
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
        $id = $this->request->get('id') ? ',' . $this->request->get('id') : '';
        $rules['title'] = 'required|max:255|unique:events,title' . $id;
        $rules['description'] = 'nullable';
        $rules['image'] = 'nullable|max:1000|mimes:jpeg,bmp,png,gif'; // max size 1 MB

        $rules['attendees'] = 'required|numeric';

        $rules['play_with_team'] = 'required';

        $rules['team_players'] = 'nullable|numeric';

        $rules['event_id'] = 'exists:events,id';
        $rules['type_id'] = 'exists:types,id';

        

        return $rules;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => 'RequestValidation',
                'msg' => $validator->errors(),
            ]),
        );
    }
}
