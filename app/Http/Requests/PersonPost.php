<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonPost extends FormRequest
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
            'name' => 'required',
            'country_id' => 'required|integer',
            'city_id' => 'required|integer',
            'lang_skills_id' => 'required',
            'dob' => 'date'
        ];
        if(!$this->input('id')){
            $rules['resume_file'] = 'required|mimes:doc,pdf';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Please insert name',
            'country_id.required' => 'Please Select Country',
            'city_id.required' => 'Please Select City',
            'lang_skills_id.required' => 'Please Select atleast one language',
            'dob.required' => 'Please give your Date of Birth',
            'resume_file.required' => 'Please upload your file in doc or pdf format'
        ];
    }
}
