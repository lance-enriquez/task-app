<?php

namespace App\Rules;

use Illuminate\Http\Request;

/**
 *
 *
 *
 */
class SaveTaskRule extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title'          => 'required|max:100',
            'content'        => 'required',
            'task_status_id' => 'required|integer',
            'is_draft'       => 'required|in:true,false'
        ];
    }

    /**
     * Returns messages when value doesn't pass the conditions.
     *
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'title.required'          => 'Title is a required field.',
            'title.max'               => 'Title length must be a maximum of 100 characters.',

            'content.required'        => 'Content is a required field.',

            'task_status_id.required' => 'Status is a required field.',

            'is_draft.boolean'        => 'Save as draft should be a boolean.',
        ];
    }
}
