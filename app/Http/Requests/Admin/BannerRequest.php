<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
class BannerRequest extends FormRequest
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
                    'title' => 'nullable|string|min:2',
                    'description' => 'nullable|string|min:2',
                    'url' => 'nullable|string|min:2',
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:20000',
                    'is_active' => 'required|in:0,1',
                ];
            }
            case 'PATCH':
            case 'PUT':
            {
                $rules= [

                    'title' => 'nullable|string|min:2',
                    'description' => 'nullable|string|min:2',
                    'url' => 'nullable|string|min:2',
                    'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:20000',
                    'is_active' => 'required|in:0,1',
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