<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class UpdateOauthUserRequest extends Request
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
        \DB::enableQueryLog();
        $id = $this->route()->getParameter('id');
        $rules = [
            'user_id'   => 'required|integer|exists:users,id|unique:oauth,user_id,'.$id.',id,provider,' . \Input::get('provider')
        ];
        return $rules;
    }
}
