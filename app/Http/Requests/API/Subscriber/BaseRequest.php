<?php

namespace App\Http\Requests\API\Subscriber;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

use App\Models\Field;
use App\Rules\Field\Email as CustomEmailRule;

/**
 * @todo Move all the fields to redis, so I can pull them
 * quicker for fetching "meta->validations" props.
 */
abstract class BaseRequest extends FormRequest
{
    /**
     * Get the validation rules for all the fields.
     *
     * @return array
     */
    protected function buildRulesForFields()
    {
        $validationRules = [
            'fields' => 'required|array',
        ];

        foreach ($this->request->get('fields') as $index => $fieldData) {
            $keyPrefix = "fields.{$index}";

            $validationRules["{$keyPrefix}.field_id"] = [
                'required',
                'integer',
                'exists:fields,id',
            ];

            $field = Field::find($fieldData['field_id']);
            if (!$field) {
                continue;
            }

            $validationRules["{$keyPrefix}.value"] = array_merge(
                $this->buildRulesForType($field),
                $this->buildCustomRules($field)
            );
        }

        return $validationRules;
    }

    /**
     * Build main validations array.
     *
     * @param  \App\Models\Field  $field
     * @return array
     */
    protected function buildRulesForType(Field $field)
    {
        $rules = [];

        if ($field->required) {
            $rules[] = 'required';
        } else {
            $rules[] = 'nullable';
        }

        switch ($field->type) {
            case 'boolean':
                $rules[] = 'boolean';
                break;

            case 'date':
                break;

            case 'list':
                if (!empty($field->meta->options)) {
                    $options = implode(',', $field->meta->options);
                    $rules[] = "in:{$options}";
                }
                break;

            case 'number':
            case 'string':
                $type = $field->type == 'number' ? 'numeric' : 'string';
                $rules[] = $type;

                if (!empty($field->meta->min)) {
                    $rules[] = "min:{$min}";
                }

                if (!empty($field->meta->max)) {
                    $rules[] = "max:{$max}";
                }
                break;
        }

        return $rules;
    }

    /**
     * Build custom validations array.
     *
     * @param  \App\Models\Field  $field
     * @return array
     */
    protected function buildCustomRules(Field $field)
    {
        $rules = [];

        if (empty($field->meta->validations)) {
            return $rules;
        }

        foreach ($field->meta->validations as $ruleName) {
            switch ($ruleName) {
                case 'email':
                    $rules[] = 'email';
                    $rules[] = new CustomEmailRule;
                    break;
                case 'unique':
                    $temporalRule = Rule::unique('subscriber_fields', 'value')
                        ->where(function ($query) use ($field) {
                            return $query->where('field_id', $field->id);
                        });
                    if (!empty($this->subscriber)) {
                        $temporalRule = $temporalRule->ignore($this->subscriber->id, 'subscriber_id');
                    }
                    $rules[] = $temporalRule;
                    break;
            }
        }

        return $rules;
    }
}
