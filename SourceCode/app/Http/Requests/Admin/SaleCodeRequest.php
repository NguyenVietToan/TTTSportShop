<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SaleCodeRequest extends FormRequest
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
            'salecode'   => 'required|unique:salecodes,salecode',
            'salepercent'        => 'required'
        ];
    }

    public function messages()
    {
        return [
            'salecode.required'   => 'Không bỏ trống mã giảm giá',
            'salecode.unique'     => 'Mã này đã tồn tại',
            'salepercent.required'        => 'Vui lòng nhập phần trăm giảm giá',
            
        ];
    }
}


