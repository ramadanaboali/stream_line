<?php

namespace App\Http\Requests\General;

use Illuminate\Foundation\Http\FormRequest;

class PromoCodeRequest extends FormRequest
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
                    'value' => 'required|numeric|min:0',
                    'discount_type' => 'required|in:percentage,fixed',
                    'category_type' => 'required|in:public,private',
                    'start_date' => 'required|date|after_or_equal:today',
                    'end_date' => 'required|date|after:start_date',
                    'user_id' => 'required_if:category_type,private|exists:users,id',
                    'uses' => 'required_if:category_type,public|integer|min:1',
                    'is_active' => 'required|in:0,1',
                ];
            }
            case 'PATCH':
            case 'PUT':
            {
                $rules= [

                    'value' => 'required|numeric|min:0',
                    'discount_type' => 'required|in:percentage,fixed',
                    'category_type' => 'required|in:public,private',
                    'start_date' => 'required|date|after_or_equal:today',
                    'end_date' => 'required|date|after:start_date',
                    'user_id' => 'required_if:category_type,private|exists:users,id',
                    'uses' => 'required_if:category_type,public|integer|min:1',
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
