<?php

namespace App\Http\Requests;

use App\Models\Portfolio;
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
        $rules = [
            'name' => 'required|min:3|max:50',
            'type' => 'required|string',
            'image' => 'required|mimes:png,jpg',
            'deploy' => 'sometimes|max:100',
            'github' => 'sometimes|max:100',
            'figma' => 'sometimes|max:100',
        ];

        if ($this->method() === 'PUT') {
            $rules = [
                'name' => 'required|min:3|max:50',
                'type' => 'required|string',
                'image' => 'sometimes|mimes:png,jpg',
                'deploy' => 'sometimes|max:100',
                'github' => 'sometimes|max:100',
                'figma' => 'sometimes|max:100',
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
