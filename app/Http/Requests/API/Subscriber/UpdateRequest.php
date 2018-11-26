<?php

namespace App\Http\Requests\API\Subscriber;

class UpdateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->buildRulesForFields();
    }
}
