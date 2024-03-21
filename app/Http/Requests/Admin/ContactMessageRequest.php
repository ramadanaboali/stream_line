<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ContactMessageRequest extends FormRequest
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
                    'message' => 'required|string|min:2',
                    'name' => 'required|string|min:2',
                    'email' => 'required|email',
                ];
            }
            case 'PATCH':
            case 'PUT':
            {
                $rules= [
                    'message' => 'required|string|min:2',
                    'name' => 'required|string|min:2',
                    'email' => 'required|email',
                    'is_read' => 'sometimes|in:0,1'
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
