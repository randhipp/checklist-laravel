<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemStoreRequest extends FormRequest
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
            'data.attribute.due' => 'date_format:Y-m-d H:i:s',
            'data.attribute.urgency' => 'string',
            'data.attribute.assignee_id' => 'required|integer',
            'data.attribute.description' => 'string',
        ];
    }
}
