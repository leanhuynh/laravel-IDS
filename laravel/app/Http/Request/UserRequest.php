<?php

namespace App\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest {

    public function authorize()
    {
        return true; // Cho phép mọi request
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:App\Models\User,name,' . $this->route('user'),
            'email' => 'required|email|unique:App\Models\User,email,' . $this->route('user'), 
            // $this->route('user'): lấy tham số từ URL với giá trị là ID của bản ghi hiện tại, chương trình sẽ bỏ qua so sánh với bản ghi có ID này 
            'password' => 'nullable|string|min:8|confirmed',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'avatar.image' => 'Phải đúng định dạng ảnh',
            'avatar.max' => 'File ảnh không được vượt quá 2MB',
            'name.required' => 'Tên là bắt buộc.',
            'name.unique' => 'Tên không được trùng',
            'name.max' =>  'Tên không được dài quá 255 ký tự',
            'email.required' => 'Email là bắt buộc.',
            'email.unique' => 'Email không được trùng',
            'email.email' => 'Email chưa đúng định dạng',
            'password.nullable' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không hợp lệ'
        ];
    }
}