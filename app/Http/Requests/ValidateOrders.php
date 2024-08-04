<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;


class ValidateOrders extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string,
     */
    public function rules(): array
    {
        return [
            'id' => 'required|alpha_num|size:8',
            'name' =>
            [
                'required', 'string', 'max:255',
                'regex:/^[A-Z]/',
                'regex:/^[a-zA-Z\s]*$/'
            ],
            'address.city' => 'required|string',
            'address.district' => 'required|string',
            'address.street' => 'required|string',
            'price' => 'required|numeric|max:2000',
            'currency' => 'required|string|in:TWD,USD',
        ];
    }


    public function messages()
    {
        return [
            'id.required' => 'ID is required',
            'id.alpha_num' => 'ID must be alphanumeric',
            'id.size' => 'ID must be exactly 8 characters',
            'name.required' => 'Name is required',
            'name.regex' =>
            [
                'regex:/^[A-Z]/' => 'Name is not capitalized',
                'regex:/^[a-zA-Z\s]*$/' => 'Name contains non-English characters'
            ],
            'address.city.required' => 'City is required',
            'address.district.required' => 'District is required',
            'address.street.required' => 'Stree is required',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price can only be a number',
            'price.max' => 'Price is over 2000',
            'currency.required' => 'Currency is required',
            'currency.in' => 'Currency format is wrong'
        ];
    }


    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = (new \Illuminate\Validation\ValidationException($validator))->errors();

        // Customize error messages for the 'name' field
        if (isset($errors['name'])) {
            foreach ($errors['name'] as $key => $error) {
                if (preg_match('/^[A-Z]/', $error)) {
                    $errors['name'][$key] = 'Name must start with a capital letter';
                }
                if (preg_match('/^[a-zA-Z\s]*$/', $error)) {
                    $errors['name'][$key] = 'Name must contain only English letters and spaces';
                }
            }
        }

        throw new \Illuminate\Validation\ValidationException($validator, response()->json(['errors' => $errors], 422));
    }
}
