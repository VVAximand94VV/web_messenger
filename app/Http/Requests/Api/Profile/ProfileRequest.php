<?php

namespace App\Http\Requests\Api\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'login' => '',
            'firstName' => '',
            'lastName' => '',
            'email' => '',
            'phone' => '',
//            'login' => ['string', 'min:6', 'max:255', 'unique:users'],
//            'firstName' => ['string', 'min:3', 'max:255'],
//            'lastName' => ['string', 'min:3', 'max:255'],
//            'email' => ['string', 'email', 'max:255', 'unique:users'],
//            'phone' => ['min:9', 'max:13', 'unique:users'],
        ];
    }
}
