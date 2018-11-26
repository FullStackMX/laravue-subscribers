<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscriber extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'deleted_at',
        'updated_at',
    ];

    /**
     * The fields that belong to the role.
     */
    public function fields()
    {
        return $this->belongsToMany(Field::class, 'subscriber_fields')
            ->using(SubscriberField::class)
            ->withPivot(
                'created_at',
                'deleted_at',
                'updated_at',
                'value'
            );
    }
}
