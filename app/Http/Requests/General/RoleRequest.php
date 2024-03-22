<?php

namespace App\Http\Requests\General;

use Illuminate\Foundation\Http\FormRequest;

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
                    'name_en' => 'required|string|min:2',
                    'name_ar' => 'required|string|min:2',
                    'is_active' => 'required|in:0,1',
                ];
            }
            case 'PATCH':
            case 'PUT':
            {
                $rules= [
                    'permissions' => 'required|array',
                    'permissions.*' => 'required|exists:permissions,id',
                    'name_en' => 'required|string|min:2',
                    'name_ar' => 'required|string|min:2',
                    'is_active' => 'required|in:0,1',
                ];
                return $rules;
            }
            default:
                return [];
        }

    }
    public function attributes()
    {
        return [

        ];
    }
}
