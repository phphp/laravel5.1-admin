<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class StoreUserRequest extends Request
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
        $rules = [
            'name'      => 'required|string|nickname|unique:users,name',
            'email'     => 'required|string|email|max:255|unique:users,email',
            'password'  => 'required|min:'.config('admin.password_min_length').'|max:'.config('admin.password_max_length'),
            'active'    => 'boolean',
            'admin'     => 'boolean',
            'avatar'    => 'image|max:'.config('admin.upload_file_size'),
        ];
        if ( $this->request->get('roles') )
        {
            foreach( $this->request->get('roles') as $k=>$v )
            {
                $rules['roles.'.$k] = 'numeric|exists:roles,id';
            }
        }
        return $rules;
    }
}
