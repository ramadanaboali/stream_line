<?php

namespace App\Http\Requests\General;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
                    'booking_id' => 'required|exists:bookings,id',
                    'service_rate' => 'required|integer|min:1|max:5',
                    'service_comment' => 'required|string|min:2',
                    'employee_rate' => 'required|integer|min:1|max:5',
                    'employee_comment' => 'required|string|min:2',
                ];
            }
            case 'PATCH':
            case 'PUT':
            {
                $rules= [

                    'booking_id' => 'required|exists:bookings,id',
                    'service_rate' => 'required|integer|min:1|max:5',
                    'service_comment' => 'required|string|min:2',
                    'employee_rate' => 'required|integer|min:1|max:5',
                    'employee_comment' => 'required|string|min:2',
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
