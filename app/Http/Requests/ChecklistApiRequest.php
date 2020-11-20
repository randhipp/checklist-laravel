<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChecklistApiRequest extends FormRequest
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
            'data.attributes.object_domain' => 'required|string',
            'data.attributes.object_id' => 'required|string',
            'data.attributes.due' => 'date_format:Y-m-d\TH:i:sP',
            'data.attributes.urgency' => 'integer',
            'data.attributes.description' => 'required|string',
            'data.attributes.items' => 'required|array',
            'data.attributes.task_id' => 'string',

        ];
    }
}
