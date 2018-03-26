<?php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
            'start_date'    =>'required',
            'email'         =>'required|email|unique:members,email',
            'password'      => 'required|min:6|max:20',
            're_password'   => 'required|same:password',
            'name'          => 'required',
            'day'           => 'required',
            'month'         => 'required',
            'year'          => 'required',
            'identity_card' => 'required',
            'phone'         => 'required|min:10|numeric',
            'address'       =>'required',
            'fImages'       => 'required|image'
        ];
    }


    public function messages(){
        return [
            'start_date.required'    => 'Bạn chưa nhập ngày bắt đầu',
            'email.required'         => 'Vui lòng nhập email của bạn',
            'email.email'            => 'Không đúng định dạng email',
            'email.unique'           => 'Email này đã có người sử dụng',
            'password.required'      => 'Vui lòng nhập mật khẩu của bạn',
            'password.min'           => 'Mật khấu có tối thiểu 6 kí tự',
            'password.max'           => 'Mật khấu có tối đa 20 kí tự',
            're_password.required'   => 'Vui lòng nhập lại mật khẩu của bạn',
            're_password.same'       => 'Mật khẩu không giống nhau',
            'name.required'          => 'Bạn chưa nhập họ tên',
            'day.required'           => 'Vui lòng chọn ngày sinh',
            'month.required'         => 'Vui lòng chọn tháng sinh',
            'year.required'          => 'Vui lòng chọn năm sinh',
            'identity_card.required' => 'Bạn chưa nhập số chứng minh nhân dân',
            'phone.min'              => 'Số điện thoại phải có ít nhất 10 chữ số',
            'phone.numeric'          => 'Số điện thoại chỉ bao gồm chữ số',
            'address.required'       => 'Bạn chưa nhập địa chỉ',
            'fImages.required'       => 'Vui lòng chọn hình ảnh',
            'fImages.image'          => 'File này không phải là một hình ảnh'
        ];
    }
}
