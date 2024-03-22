<?php

namespace App\Http\Requests\General;

use Illuminate\Foundation\Http\FormRequest;

class ClientCancellationReasonRequest extends FormRequest
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
                    'reason_ar' => 'required|string|min:2|unique:client_cancellation_reasons,reason_ar',
                    'reason_en' => 'required|string|min:2|unique:client_cancellation_reasons,reason_en',
                    'is_active' => 'required|in:0,1',
                ];
            }
            case 'PATCH':
            case 'PUT':
            {
                $rules= [

                    'reason_ar' => 'required|string|min:2',
                    'reason_en' => 'required|string|min:2',
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
