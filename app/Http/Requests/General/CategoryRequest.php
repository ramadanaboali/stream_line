<?php

namespace App\Http\Requests\General;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
                    'name_ar' => 'required|string|min:2|unique:categories,name_ar',
                    'name_en' => 'required|string|min:2|unique:categories,name_en',
                    'icon' => 'required|image|mimes:jpeg,png,jpg,gif|max:20000',
                    'is_active' => 'required|in:0,1',
                ];
            }
            case 'PATCH':
            case 'PUT':
            {
                $rules= [

                    'name' => 'required|string|min:2',
                    'name_en' => 'required|string|min:2',
                    'icon' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:20000',
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
}
