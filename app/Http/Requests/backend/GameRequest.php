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

        // https://codeanddeploy.com/blog/laravel/laravel-8-user-roles-and-permissions-step-by-step-tutorial
        // $game = request()->route('game');
        // $id = $game->id;

        $rules['title']              = 'required|max:255|unique:games,title' . $id;
        $rules['description']        = 'nullable';
        $rules['image']              = 'nullable|max:1000|mimes:jpeg,bmp,png,gif|max:1000'; // max size 1 MB
        $rules['type_id']            = 'required|exists:types,id';
        $rules['brand_id']           = 'required|exists:brands,id';
        $rules['group_id']           = 'required|exists:groups,id';
        $rules['attendees']          = 'required|numeric';
        $rules['play_with_team']     = 'nullable|in:0,1';
        $rules['team_players']       = 'nullable|numeric';
        $rules['color']              = 'required';
        $rules['event_title']        = 'required|max:255';
        $rules['event_date_range']   = 'required';
        $rules['event_location']     = 'required|max:255';

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
