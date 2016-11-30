<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;
use Illuminate\Validation\Rule;

class UpdateProfile extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user = Auth::user();
        return [
            'name' => 'required|max:60',
            'email' => [
                'required',
                'max:60',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'min:6|confirmed',
            'password_confirmation' => 'min:6',
            'chatwork_id' => 'confirmed|max:25',
            'chatwork_id_confirmation' => 'max:25',
        ];
    }
}
