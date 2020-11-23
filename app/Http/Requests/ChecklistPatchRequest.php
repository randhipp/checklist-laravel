<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChecklistPatchRequest extends FormRequest
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
        return [
            'data' => 'required',
            'data.attributes' => 'required',
            'data.attributes.object_domain' => 'string',
            'data.attributes.object_id' => 'string',
            'data.attributes.due' => 'date_format:Y-m-d\TH:i:sP',
            'data.attributes.urgency' => 'integer',
            'data.attributes.description' => 'string',
            'data.attributes.items' => 'array',
            'data.attributes.task_id' => 'string',
        ];
    }
}
