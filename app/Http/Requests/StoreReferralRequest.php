<?php

namespace App\Http\Requests;

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
                Rule::unique('referrals', 'recipient_email')->where(function ($query) {
                    return $query->where('referrer_user_id', $this->user()->id);
                })
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
            'emails.min'        => 'An email address is required.',
            'emails.*.required' => 'An email address is required.',
            'emails.*.distinct' => 'The email address :input has a duplicate value.',
            'emails.*.unique'   => ':input is already invited or registered to ContactOut.',
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
