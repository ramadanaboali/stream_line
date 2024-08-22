<?php

namespace App\Http\Requests\General;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class RoleRequest extends FormRequest
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
                    'permissions' => 'required|array',
                    'permissions.*' => 'required|exists:permissions,id',
                    'name' => 'required|string|min:2|unique:roles,name',
                    'display_name' => 'required|string|min:2',
                    'is_active' => 'required|in:0,1',
                ];
            }
            case 'PATCH':
            case 'PUT':
            {
                $rules= [
                    'permissions' => 'required|array',
                    'permissions.*' => 'required|exists:permissions,id',
                    'name' => 'required|string|min:2',
                    'display_name' => 'required|string|min:2',
                    'is_active' => 'required|in:0,1',
                ];
                return $rules;
            }
            default:
                return [];
        }

    }
     protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(apiResponse(false, null, 'Validation Error', $errors, 401));
    }
}
