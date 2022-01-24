<?php

namespace App\Http\Requests;

use App\Enum\SexEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateDeveloperRequest extends FormRequest
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
            'name' => ['required'],
            'sex' => [
                'required',
                Rule::in(SexEnum::MASCULINE, SexEnum::FEMININE)
            ],
            'age' => ['required', 'numeric'],
            'hobby' => ['required'],
            'birthdate' => ['required', 'date', 'date-format:Y-m-d']
        ];
    }
}
