<?php

namespace App\Http\Requests\General;

use Illuminate\Foundation\Http\FormRequest;

class ReviewReportRequest extends FormRequest
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
                    'review_id' => 'required|exists:reviews,id',
                    'comment' => 'required|string|min:2',
                ];
            }
            case 'PATCH':
            case 'PUT':
            {
                $rules= [

                    'review_id' => 'required|exists:reviews,id',
                    'comment' => 'required|string|min:2',
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
