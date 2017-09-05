<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class UpdatePermissionRequest extends Request
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
        $permissionId = $this->route()->getParameter('id');
        return [
            'name' => 'required|string|max:255|unique:permissions,name,'.$permissionId,
            'url' => 'required|string|max:255|unique:permissions,url,'.$permissionId,
            'code' => 'required|string|max:255|unique:permissions,code,'.$permissionId,
        ];
    }
}
