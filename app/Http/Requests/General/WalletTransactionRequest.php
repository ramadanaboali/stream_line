<?php

namespace App\Http\Requests\General;

use Illuminate\Foundation\Http\FormRequest;

class WalletTransactionRequest extends FormRequest
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
                    'value' => 'required|numeric|min:0.1',
                    'description' => 'nullable|string|min:2',
                    'wallet_id' => 'required|exists:wallets,id',
                    'type' => 'required|in:debit,credit',
                    'is_active' => 'required|in:0,1',
                ];
            }
            case 'PATCH':
            case 'PUT':
            {
                $rules= [

                    'value' => 'required|numeric|min:0.1',
                    'description' => 'nullable|string|min:2',
                    'wallet_id' => 'required|exists:wallets,id',
                    'type' => 'required|in:debit,credit',
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
