<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'cateParent'     => 'required',
            'sportParent'    => 'required',
            'brandParent'    => 'required',
            'txtProName'     => 'required|unique:products,name',
            'fImages'        => 'required|image',
            'txtImportPrice' => 'required',
            'txtPrice'       => 'required',
            'chooseGender'   => 'required'
        ];
    }

    public function messages()
    {
        return [
            'cateParent.required'     => 'Vui lòng chọn thể loại',
            'sportParent.required'    => 'Vui lòng chọn bộ môn',
            'brandParent.required'    => 'Vui lòng chọn thương hiệu',
            'txtProName.required'     => 'Vui lòng nhập tên sản phẩm',
            'txtProName.unique'       => 'Tên sản phẩm này đã tồn tại',
            'fImages.required'        => 'Vui lòng chọn một hình ảnh',
            'fImages.image'           => 'File này không phải một hình ảnh',
            'txtImportPrice.required' => 'Vui lòng nhập giá nhập của sản phẩm',
            'txtPrice.required'       => 'Vui lòng nhập giá bán của sản phẩm',
            'chooseGender.required'   => 'Vui lòng chọn giới tính'
        ];
    }
}
