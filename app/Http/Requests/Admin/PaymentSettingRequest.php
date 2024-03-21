<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PaymentSettingRequest extends FormRequest
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
                    'online_on_delivery_payment' => 'required|in:0,1',
                    'online_payment' => 'required|in:0,1'
                ];
            }
            case 'PATCH':
            case 'PUT':
            {
                $rules= [

                    'online_on_delivery_payment' => 'required|in:0,1',
                    'online_payment' => 'required|in:0,1'
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
