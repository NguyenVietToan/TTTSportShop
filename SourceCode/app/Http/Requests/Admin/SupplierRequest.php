<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'name'    => 'required',
            'address' => 'required',
            'phone'   => 'required|numeric',
            'email'   => 'required|email|unique:suppliers,email'
        ];
    }


    public function messages(){
        return [
            'name.required'    => 'Vui lòng nhập tên nhà cung cấp',
            'address.required' => 'Vui lòng nhập địa chỉ',
            'phone.required'   => 'Vui lòng nhập số điện thoại',
            'phone.numeric'    => 'Số điện thoại phải ở dạng số',
            'email.required'   => 'Vui lòng nhập email',
            'email.email'      => 'Email không đúng định dạng',
            'email.unique'     => 'Email này đã tồn tại'
        ];
    }
}
