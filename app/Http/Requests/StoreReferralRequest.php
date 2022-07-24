<?php

namespace App\Http\Requests;

use App\Rules\UninvitedEmail;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReferralRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'emails' => [
                'array',
                'min:1',
                'max:20',
            ],
            'emails.*' => [
                'required',
                'email',
                'distinct',
                'unique:users,email',
                new UninvitedEmail(),
            ],
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
            'emails.min'        => 'An :attribute is required.',
            'emails.*.required' => 'An :attribute is required.',
            'emails.*.distinct' => 'The :attribute :input has a duplicate value.',
            'emails.*.unique'   => ':input is already using ContactOut.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'emails.*' => 'email address',
        ];
    }
}
