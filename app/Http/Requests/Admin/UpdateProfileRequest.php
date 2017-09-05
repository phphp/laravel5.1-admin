<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class UpdateProfileRequest extends Request
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
        $userId = SELF::user()->id;
        $rules = [
            'name'      => 'required|string|max:255|unique:users,name,'.$userId,
            'email'     => 'required|email|max:255|unique:users,email,'.$userId,
            'password'  => 'min:'.config('admin.password_min_length').'|max:'.config('admin.password_max_length').'|confirmed',
            'avatar'    => 'image|max:'.config('admin.upload_file_size'),
        ];
        return $rules;
    }
}
