<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
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
                    'name_ar' => 'required|string|min:2|unique:categories,name_ar',
                    'name_en' => 'required|string|min:2|unique:categories,name_en',
                    'description_ar' => 'required|string|min:2',
                    'description_en' => 'required|string|min:2',
                    'period' => 'required|in:unknown,days,month,quarter,half_year,year',
                    'type' => 'required|in:public,private',
                    'subscription_type' => 'required|in:subscribe,commission,subscribe_and_commission',
                    'days' => 'required_if:period,days|integer|min:1',
                    'unknown_price' => 'required_if:period,unknown|numeric|min:1',
                    'days_price' => 'required_if:period,days|numeric|min:1',
                    'month_price' => 'required_if:period,month|numeric|min:1',
                    'quarter_price' => 'required_if:period,quarter|numeric|min:1',
                    'half_year_price' => 'required_if:period,half_year|numeric|min:1',
                    'year_price' => 'required_if:period,year|numeric|min:1',
                    'manager_role_id' => 'sometimes|integer',
                    'commission' => 'sometimes|numeric|min:1',
                    'features' => 'sometimes|string|min:2',
                    'sms_messages' => 'required|integer',
                    'whatsapp_messages' => 'required|integer',
                    'policy' => 'required|string|min:2',
                    'is_default' => 'required|in:0,1',
                    'is_active' => 'required|in:0,1',
                ];
            }
            case 'PATCH':
            case 'PUT':
            {
                $rules= [

                    'name' => 'required|string|min:2',
                    'name_en' => 'required|string|min:2',
                    'description_ar' => 'required|string|min:2',
                    'description_en' => 'required|string|min:2',
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
