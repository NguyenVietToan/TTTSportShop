<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SportRequest extends FormRequest
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
            'txtSportName' => 'required|unique:sports,name',
            'fImages'      => 'required|image'
        ];
    }

    public function message ()
    {
        return [
            'txtSportName.required' => 'Vui lòng nhập tên bộ môn',
            'txtSportName.unique'   => 'Tên bộ môn này đã tồn tại',
            'fImages.required'      => 'Vui lòng chọn hình ảnh',
            'fImages.image'         => 'File này không phải là một hình ảnh'
        ];
    }
}
