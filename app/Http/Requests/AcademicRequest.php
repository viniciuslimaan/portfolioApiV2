<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AcademicRequest extends FormRequest
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
            'semester' => 'required|unique:academics',
            'image' => 'required|mimes:png,jpg',
            'description' => 'sometimes',
        ];

        if ($this->method() === 'PUT') {
            $rules = [
                'name' => 'required|min:3|max:50',
                'semester' => 'required|unique:academics,semester,'.$this->id,
                'image' => 'sometimes|mimes:png,jpg',
                'description' => 'sometimes',
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
