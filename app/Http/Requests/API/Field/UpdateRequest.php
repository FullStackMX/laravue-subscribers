<?php

namespace App\Http\Requests\API\Field;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'meta' => 'nullable|json',
            'name' => 'required|string|min:3|max:50|unique:fields,name,' . $this->field->id,
            'protected' => 'required|boolean',
            'required' => 'required|boolean',
            'title' => 'required|string|min:3|max:250',
            'type' => 'required|in:boolean,date,list,number,string',
        ];
    }
}
