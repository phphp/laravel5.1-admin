<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class UpdateUserRequest extends Request
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
        $userId = $this->route()->getParameter('id');
        $rules = [
            'name'      => 'required|string|nickname|unique:users,name,'.$userId,
            'email'     => 'email|max:255|unique:users,email,'.$userId,
            'password'  => 'min:'.config('admin.password_min_length').'|max:'.config('admin.password_max_length').'|confirmed',
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
