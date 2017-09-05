<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class UpdateTagRequest extends Request
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
        $tagId = $this->route()->getParameter('id');
        $rules = [
            'name'      => 'required|string|max:255|unique:tags,name,'.$tagId,
            'slug'      => 'required|string|max:255|unique:tags,slug,'.$tagId,
        ];
        return $rules;
    }
}
