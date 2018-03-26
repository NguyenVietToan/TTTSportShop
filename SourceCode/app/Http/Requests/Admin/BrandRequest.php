<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BrandRequest extends FormRequest
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
            'txtBrandName'   => 'required|unique:brands,name',
            'fImages'        => 'required|image'
        ];
    }

    public function messages()
    {
        return [
            'txtBrandName.required'   => 'Vui lòng nhập tên thương hiệu',
            'txtBrandName.unique'     => 'Tên thương hiệu này đã tồn tại',
            'fImages.required'        => 'Vui lòng chọn hình ảnh',
            'fImages.image'           => 'File này không phải là một hình ảnh'
        ];
    }
}


