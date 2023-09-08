<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PortfolioRequest extends FormRequest
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
            'name' => 'required|min:3|max:50',
            'type' => 'required|unique:portfolios',
            'image' => 'required',
            'deploy' => 'sometimes|max:100',
            'github' => 'sometimes|max:100',
            'figma' => 'sometimes|max:100',
        ];
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
