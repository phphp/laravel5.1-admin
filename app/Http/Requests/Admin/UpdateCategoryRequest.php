<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class UpdateCategoryRequest extends Request
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
        $categoryId = $this->route()->getParameter('id');
        $rules = [
            'name'      => 'required|string|max:255|unique:categories,name,'.$categoryId,
            'slug'      => 'required|string|max:255|unique:categories,slug,'.$categoryId,
        ];
        return $rules;
    }
}
