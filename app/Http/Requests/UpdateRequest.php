<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
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
        return [
            'first_name' => 'max:255',
            'last_name' => 'max:255',
            'email' => 'unique:users,email|regex:/^.+@.+$/i'
        ];
    }
    public function messages()
    {
        return [
            'first_name.max' => 'First name too long!',
            'last_name.max' => 'Last name too long!',
            'email.regex' => 'The format email is not correct',
            'email.unique' => 'The email has been existed',
        ];
    }

    protected function failedValidation(Validator $validator)
    {

        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json(
            [
                'code'=>0,
                'error' => $errors
            ]));
    }

}

