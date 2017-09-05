<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class AjaxStoreTagRequest extends Request
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
            'new_tag_name'      => 'required|string|max:255|unique:tags,name',
            'new_tag_slug'      => 'required|string|max:255|unique:tags,slug',
        ];
        return $rules;
    }
}
