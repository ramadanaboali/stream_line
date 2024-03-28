<?php

namespace App\Http\Requests\General;

use Illuminate\Foundation\Http\FormRequest;

class UserNotificationSettingRequest extends FormRequest
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
                    'email' => 'required|in:0,1',
                    'whatsapp' => 'required|in:0,1',
                    'sms' => 'required|in:0,1'
                ];
            }
            case 'PATCH':
            case 'PUT':
            {
                $rules= [

                    'email' => 'required|in:0,1',
                    'whatsapp' => 'required|in:0,1',
                    'sms' => 'required|in:0,1'
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
