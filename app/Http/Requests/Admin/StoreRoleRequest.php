<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class StoreRoleRequest extends Request
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
            'name' => 'required|string|max:255|unique:roles'
        ];
        if ( $this->request->get('permissions') )
        {
            foreach( $this->request->get('permissions') as $k=>$v )
            {
                $rules['permissions.'.$k] = 'numeric|exists:permissions,id';
            }
        }
        return $rules;
    }
}
