<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductEditRequest extends FormRequest
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
            'txtProName' => 'required',
            'txtPrice'   => 'required'
        ];
    }

    public function messages()
    {
        return [
            'txtProName.required' => 'Vui lòng nhập tên sản phẩm',
            'txtPrice.required'   => 'Vui lòng nhập giá sản phẩm'
        ];
    }
}
