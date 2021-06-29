<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeneralProductRequest extends FormRequest
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
            'name' => 'required|max:100',
            'slug' => 'required|unique:products,slug,' . $this->id,
            'description' => 'required|max:1000',
            'short_description' => 'max:500',
            'categories' => 'required|array|min:1',
            'categories.*' => 'numeric|exists:categories,id',
            'tags' => 'nullable|array|min:1',
            'tags.*' => 'numeric|exists:tags,id',
            'brand_id' => 'exists:brands,id',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'هذا الحقل مطلوب',
            'array' => 'الحقل يجب ان يكون مصفوفة',
            'exists' => 'القيمة غير موجودة',
            'numeric' => 'يجب ان تكون قيم ةالحقل رقم',
            'unique' => 'هذا الحقل موجود مسبقا',
            'max' => 'الحقل تجاوز عدد الاحرف المطلوبة',
            'min' => 'الحقل يجب ان يحتوي على عنصر واحد على الاقل',
        ];
    }
}
