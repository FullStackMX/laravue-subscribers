<?php

namespace App\Http\Requests\API\Field;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'name' => 'required|alpha_dash|min:3|max:50|unique:fields,name',
            'protected' => 'required|boolean',
            'required' => 'required|boolean',
            'title' => 'required|string|min:3|max:250',
            'type' => 'required|in:boolean,date,list,number,string',
        ];
    }
}
