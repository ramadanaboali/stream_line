<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
class VendorRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules() : array
    {

        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'provider_name'    => 'required|min:3|max:20',
                    'commercial_no'    => 'required|min:3|max:20',
                    'description'      => 'nullable|min:3|max:20',
                    'website_url'      => 'nullable|min:3|max:20',
                    'twitter'          => 'nullable|min:3|max:20',
                    'instagram'        => 'nullable|min:3|max:20',
                    'snapchat'         => 'nullable|min:3|max:20',
                    'registered_tax'   => 'required|in:0,1',
                    'tax_number'       => 'required_if:registered_tax,1',
                    'category_id'    => 'required|array',
                    'category_id.*'  => 'required|exists:categories,id',
                    'email'            => 'required|email|unique:users,email',
                    'first_name'       => 'required|min:3|max:20',
                    'last_name'        => 'required|min:3|max:20',
                    'phone'            => 'required|numeric|unique:users',
                    'password'         => 'required|min:8|confirmed',
                    'is_active'         => 'required|in:0,1',
                ];
            }
            case 'PATCH':
            case 'PUT':
            {
                $rules= [

                    'provider_name'    => 'required|min:3|max:20',
                    'commercial_no'    => 'required|min:3|max:20',
                    'description'      => 'nullable|min:3|max:20',
                    'website_url'      => 'nullable|min:3|max:20',
                    'twitter'          => 'nullable|min:3|max:20',
                    'instagram'        => 'nullable|min:3|max:20',
                    'snapchat'         => 'nullable|min:3|max:20',
                    'registered_tax'   => 'required|in:0,1',
                    'tax_number'       => 'required_if:registered_tax,1',
                    'category_id'    => 'required|array',
                    'category_id.*'  => 'required|exists:categories,id',
                    'email'            => 'required|email|unique:users,email',
                    'first_name'       => 'required|min:3|max:20',
                    'last_name'        => 'required|min:3|max:20',
                    'phone'            => 'required|numeric|unique:users',
                    'is_active'         => 'required|in:0,1',
                ];
                return $rules;
            }
            default:
                return [];
                break;
        }

    }
    public function attributes()
    {
        return [

        ];
    }
  protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(apiResponse(false, null, 'Validation Error', $errors, 401));
    }
}
