<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingRequest extends FormRequest
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
            'id' => 'exist:settings',
            'value' => 'required',
            'plan_value' => 'nullable|numeric',
        ];
    }

    public function messages()
    {
        return [
            'required' => __('dashboard.required'),
            'numeric' => __('dashboard.numeric'),
        ];
    }
}
