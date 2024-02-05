<?php

namespace App\Rules;

use Illuminate\Http\Request;

/**
 *
 *
 *
 */
class RegistrationFormRule extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'username'         => 'required|string|max:20',
            'password'         => 'required|string|max:20|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'required|string|max:20|required_with:password|same:password'
        ];
    }

    /**
     * Returns messages when value doesn't pass the conditions.
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'username.required'              => 'Username is a required field.',
            'username.string'                => 'Username should be a string.',
            'username.max'                   => 'Username length must be a maximum of 20 characters.',

            'password.required'              => 'Password is a required field.',
            'password.string'                => 'Password should be a string.',
            'password.max'                   => 'Password length must be a maximum of 20 characters.',
            'password.required_with'         => 'Password and Confirm Password should be the same.',
            'password.required_same'         => 'Password and Confirm Password should be the same.',

            'confirm_password.required'      => 'Confirm Password is a required field.',
            'confirm_password.string'        => 'Confirm Password should be a string.',
            'confirm_password.max'           => 'Confirm Password length must be a maximum of 20 characters.',
            'confirm_password.required_with' => 'Password and Confirm Password should be the same.',
            'confirm_password.required_same' => 'Password and Confirm Password should be the same.'
        ];
    }
}
