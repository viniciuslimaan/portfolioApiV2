<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
        $rules = [
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users|min:5|max:50',
            'password' => 'required|min:6',
        ];

        if ($this->method('PUT')) {
            $rules = [
                'name' => 'required|min:3|max:50',
                'email' => 'required|email|min:5|max:50',
                'password' => 'nullable|min:6',
            ];
        }

        return $rules;
    }

    /**
     * Handle the validation response.
     *
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'data' => [
                'msg' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ]
        ], 422));
    }
}
