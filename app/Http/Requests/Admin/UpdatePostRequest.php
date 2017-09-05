<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;

class UpdatePostRequest extends Request
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
        $postId = $this->route()->getParameter('id');
        $rules = [
            'title'     => 'required|string|max:255',
            'slug'      => 'required|string|max:255|unique:posts,slug,'.$postId,
            'status'    => 'required|in:public,hidden',
            'type'      => 'required|in:post,page',
            'content'   => 'required',
            'category'  => 'required|numeric|exists:categories,id',
        ];
        if ( $this->request->get('tags') )
        {
            foreach( $this->request->get('tags') as $k=>$v )
            {
                $rules['tags.'.$k] = 'numeric|exists:tags,id';
            }
        }
        return $rules;
    }
}
