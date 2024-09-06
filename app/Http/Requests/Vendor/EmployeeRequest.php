<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class EmployeeRequest extends FormRequest
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
                        'first_name' => 'required|string|min:2',
                        'job_title' => 'sometimes|string|min:2',
                        'last_name' => 'required|string|min:2',
                        'email' => 'required|email|unique:users,email',
                        'phone' => 'required|numeric|unique:users,phone',
                        'salary' => 'nullable|numeric',
                        'start_date' => 'required|date',
                        'end_date' => 'nullable|date|after:start_date',
                        'image' => 'nullable|image|mimes:png,jpg,jpeg',
                        'officialHours' => 'required|array',
                        'officialHours.*.day' =>'required|in:sat,sun,mon,tue,wed,thu,fri',
                        'officialHours.*.start_time' =>'required|date_format:H:i',
                        'officialHours.*.end_time' =>'required|date_format:H:i',
                        'breakHours' => 'nullable|array',
                        'breakHours.*.day' =>'nullable|in:sat,sun,mon,tue,wed,thu,fri',
                        'breakHours.*.start_time' =>'nullable|date_format:H:i',
                        'breakHours.*.end_time' =>'nullable|date_format:H:i',
                        'password' => 'required|string|min:4|confirmed',
                        'branch_id' => 'required|exists:branches,id',
                        'service_id' => 'required|array',
                        'service_id.*' => 'required|exists:services,id',
                    ];
                }
            case 'PATCH':
            case 'PUT':
                {

                    $rules = [
                    'phone' => 'sometimes|unique:users,phone,'.request()->employee->user->id,
                    'email' => 'sometimes|unique:users,email,'.request()->employee->user->id,
                    'first_name' => 'sometimes|string|min:2',
                    'last_name' => 'sometimes|string|min:2',
                    'salary' => 'sometimes|numeric',
                    'start_date' => 'sometimes|date',
                    'end_date' => 'sometimes|date|after:start_date',
                    'image' => 'sometimes|image|mimes:png,jpg,jpeg',
                    'officialHours' => 'sometimes|array',
                    'officialHours.*.day' =>'sometimes|in:sat,sun,mon,tue,wed,thu,fri',
                    'officialHours.*.start_time' =>'sometimes|date_format:H:i',
                    'officialHours.*.end_time' =>'sometimes|date_format:H:i',
                    'breakHours' => 'sometimes|array',
                    'breakHours.*.day' =>'sometimes|in:sat,sun,mon,tue,wed,thu,fri',
                    'breakHours.*.start_time' =>'sometimes|date_format:H:i',
                    'breakHours.*.end_time' =>'sometimes|date_format:H:i',
                    'branch_id' => 'sometimes|exists:branches,id',
                    'service_id' => 'sometimes|array',
                    'service_id.*' => 'sometimes|exists:services,id',
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
