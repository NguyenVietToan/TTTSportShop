<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            'newsCate'   => 'required',
            'txtTitle'   => 'required|unique:news,title',
            'txtSummary' => 'required',
            'txtContent' => 'required',
            'fImages'    => 'image'
        ];
    }

    public function messages()
    {
        return [
            'newsCate.required'   => 'Vui lòng chọn loại tin',
            'txtTitle.required'   => 'Vui lòng nhập tiêu đề tin',
            'txtTitle.unique'     => 'Tiêu đề này đã tồn tại',
            'txtSummary.required' => 'Vui lòng nhập tóm tắt tin',
            'txtContent.required' => 'Vui lòng nhập nội dung tin',
            'fImages.image'       => 'File này không phải một hình ảnh'
        ];
    }
}
