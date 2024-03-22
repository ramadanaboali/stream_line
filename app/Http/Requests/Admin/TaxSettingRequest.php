<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TaxSettingRequest extends FormRequest
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
                    'tax_percentage' => 'required|integer|min:0|max:100'
                ];
            }
            case 'PATCH':
            case 'PUT':
            {
                $rules= [

                    'tax_percentage' => 'required|integer|min:1'
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
