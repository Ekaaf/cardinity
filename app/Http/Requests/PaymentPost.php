<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentPost extends FormRequest
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
        $rules = [
            'pan_number' => 'required',
            'exp_data' => 'required',
            'cvv' => 'required|integer'
        ];
        return $rules;
    }

    public function messages()
    {
        return [
            'pan_number.required' => 'Please give your card number',
            'exp_data.required' => 'Please give exp date',
            'cvv.required' => 'Please give cvv'
        ];
    }
}
