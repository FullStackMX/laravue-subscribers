<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriberField extends Pivot
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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'field_id',
        'subscriber_id',
        'value',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'subscriber_fields';

    /**
     * Scope a query to filter with value defined.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithValue($query)
    {
        return $query->whereNotNull('value');
    }

    /**
     * Get the field that owns the data.
     */
    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    /**
     * Get the subscriber that owns the data.
     */
    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }
}
