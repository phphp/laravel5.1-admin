<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class CreateDirectoryRequest extends Request
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
        /**
         * current_folder 为 xxx || xxx/yyy || ''
         */
        return [
            'current_folder'        => array('regex:/^(?:[a-z0-9_\-\/]+|)$/'),
            'new_directory_name'    => 'required|regex:/^[a-z0-9_-]+$/',
        ];
    }
}
