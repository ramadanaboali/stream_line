<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SystemNotificationRequest extends FormRequest
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
                    'sender_id' => 'sometimes|integer|exists:users,id',
                    'receiver_id' => 'sometimes|integer|exists:users,id',
                    'url' => 'sometimes|string|min:2',
                    'is_system' => 'sometimes|in:0,1',
                    'is_read' => 'sometimes|in:0,1',
                ];
            }
            case 'PATCH':
            case 'PUT':
            {
                $rules= [

                    'message' => 'sometimes|string|min:2',
                    'sender_id' => 'sometimes|integer|exists:users,id',
                    'receiver_id' => 'sometimes|integer|exists:users,id',
                    'url' => 'sometimes|string|min:2',
                    'is_system' => 'sometimes|in:0,1',
                    'is_read' => 'sometimes|in:0,1',
                    'is_active' => 'sometimes|in:0,1',
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
