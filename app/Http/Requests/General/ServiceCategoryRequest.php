<?php

namespace App\Http\Requests\General;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class ServiceCategoryRequest extends FormRequest
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
                    'name_ar' => 'required|string|min:2|unique:service_categories,name_ar',
                    'name_en' => 'required|string|min:2|unique:service_categories,name_en',
                    'category_id' => 'required|exists:categories,id',
                    'main_service_category_id' => 'required_if:type,sub|exists:service_categories,id',
                    'type' => 'required|in:main,sub',
                    'is_active' => 'required|in:0,1',
                ];
            }
            case 'PATCH':
            case 'PUT':
            {
                $rules= [

                    'name_ar' => 'required|string|min:2',
                    'name_en' => 'required|string|min:2',
                    'category_id' => 'required|exists:categories,id',
                    'main_service_category_id' => 'required_if:type,sub|exists:service_categories,id',
                    'type' => 'required|in:main,sub',
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
