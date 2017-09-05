<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class AdminLoginRequest extends Request
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
        $name_max_length = config('admin.name_max_length');
        $password_min_length = config('admin.password_min_length');
        $password_max_length = config('admin.password_max_length');
        return [
            'name'      => "required|max:$name_max_length",
            'password'  => "required|min:$password_min_length|max:$password_max_length",
            'captcha'   => 'required|captcha|size:4',
        ];
    }
}
