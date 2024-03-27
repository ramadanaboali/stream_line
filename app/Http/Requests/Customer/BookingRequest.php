<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class BookingRequest extends FormRequest
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
    public function rules(): array
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
                        'employee_id' => 'sometimes|exists:employees,id',
                        'booking_day' => 'required|date',
                        'booking_time' => 'required|date_format:H:i',
                        'attendance' => 'required|in:0,1',
                        'sub_total'=>'required|numeric',
                        'discount'=>'required|numeric',
                        'total'=>'required|numeric',
                        'payment_way' => 'required|in:online,cash',
                        'discount_code' => 'required',
                        'notes' => 'sometimes|string|min:3',
                        'service_id' => 'required|exists:services,id',
                        'offer_id' => 'sometimes|exists:offers,id',
                    ];
                }
            case 'PATCH':
            case 'PUT':
                {
                    $rules = [

                    ];
                    return $rules;
                }
            default:
                return [];
        }

    }
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(apiResponse(false, null, 'Validation Error', $errors, 401));
    }
}
