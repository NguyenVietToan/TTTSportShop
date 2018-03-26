<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
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
            'vcate_id' => 'required',
            'title'    => 'required|unique:videos,title',
            'image'    => 'required|image',
            'link'     => 'required'
        ];
    }

    public function messages()
    {
        return [
            'vcate_id.required' => 'Vui lòng chọn thể loại tin',
            'title.required'    => 'Vui lòng nhập tiêu đề video',
            'title.unique'      => 'Tiêu đề này đã tồn tại',
            'image.required'    => 'Vui lòng chọn hình ảnh',
            'image.image'       => 'File bạn chọn không phải là một hình ảnh',
            'link.required'     => 'Vui lòng nhập ID video trên youtube'
        ];
    }
}
