<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'provider_name'    => 'required|min:3|max:20',
            'commercial_no'    => 'required|min:3|max:20',
            'description'      => 'nullable|min:3|max:20',
            'website_url'      => 'nullable|min:3|max:20',
            'twitter'          => 'nullable|min:3|max:20',
            'instagram'        => 'nullable|min:3|max:20',
            'snapchat'         => 'nullable|min:3|max:20',
            'registered_tax'   => 'required|in:0,1',
            'tax_number'       => 'required_if:registered_tax,1',
            'service_id'       => 'required|array',
            'service_id.*'     => 'required|exists:services,id',
            'email'            => 'required|email|unique:users,email',
            'first_name'       => 'required|min:3|max:20',
            'last_name'        => 'required|min:3|max:20',
            'phone'            => 'required|numeric|unique:users|digits:9',
            'password'         => 'required|min:8|confirmed',
            // 'branch_name_ar'   => 'required_if:branch,1',
            // 'branch_name_en'   => 'required_if:branch,1',
            // 'address'          => 'required_if:branch,1',
            // 'image'            => 'required_if:branch,1',
            // 'lat'              => 'required_if:branch,1',
            // 'long'             => 'required_if:branch,1',
            // 'country_id'       => 'required_if:branch,1|exists:countries,id',
            // 'city_id'          => 'required_if:branch,1|exists:cities,id',
            // 'region_id'        => 'required_if:branch,1|exists:regions,id',
            // 'branch_official_hours'              => 'required_if:branch,1|array',
            // 'branch_official_hours.*.start_time' => 'required_if:branch,1',
            // 'branch_official_hours.*.end_time'   => 'required_if:branch,1',
            // 'branch_official_hours.*.day'        => 'required_if:branch,1|in:sat,sun,mon,tu,we,th,fr',

        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required'   => 'يجب ادخال الاسم الاول بشكل صحيح !!',
            'first_name.string'     => 'الاسم الاول يجب ان يكون حروف فقط !!',
            'first_name.max'        => 'الاسم الاول لا يمكن ان يكون اكبر من 20 حرف !! ',
            'first_name.min'        => 'الاسم الاول لا يمكن ان يكون اقل من 3 احرف !! ',
            
            'last_name.required'   => 'يجب ادخال الاسم الاخير بشكل صحيح !!',
            'last_name.string'     => 'الاسم الاخير يجب ان يكون حروف فقط !!',
            'last_name.max'        => 'الاسم الاخير لا يمكن ان يكون اكبر من 20 حرف !! ',
            'last_name.min'        => 'الاسم الاخير لا يمكن ان يكون اقل من 3 احرف !! ',

            'email.required'     => 'البريد الألكتروني مطلوب',
            'email.email'     => 'ادخل البريد الألكتروني بشكل صحيح',
            'email.unique'     => 'البريد الأليكتروني مسجل لدينا بالفعل',
            'email.max'     => 'البريد الأليكتروني يجب ان يكون اقل من 50 حرف',


            // 'country_id.required'     => 'رجاء اختيار الدولة',

            'password.required'     => 'كلمة المرور مطلوبة',
            'password.confirmed'     => 'كلمة المرور غير متطابقة',
            'password.min'     => 'كلمة المرور يجب ان تكون 8 احرف علي الاـقل',

            'phone.required'     => 'رقم الجوال مطلوب',
            'phone.unique'     => 'رقم الجوال مسجل لدينا بالفعل',
            'phone.numeric'     => 'رقم الجوال يجب ان يكون ارقام فقط',
            'phone.digits'     => 'رجاء ادخال رقم الجوال بالصيغة الدولية',

        ];
    }

     protected function prepareForValidation()
     {
         $this->merge([
             'phone' => preg_replace('/\D/', '', $this->phone),
            ]);
     }
   protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(apiResponse(false, null, 'Validation Error', $errors, 401));
    }
}

