<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Field extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'object',
    ];

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
        'meta',
        'name',
        'protected',
        'required',
        'title',
        'type',
    ];

    /**
     * Mutator for meta.
     *
     * @param mixed $value
     */
    public function setMetaAttribute($value)
    {
        $this->attributes['meta'] = is_string($value) ? $value : json_encode($value);
    }

    /**
     * Scope a query to filter by required flag.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int $required
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRequired($query, int $required = 1)
    {
        return $query->where('required', $required);
    }

    /**
     * Scope a query to filter by protected flag.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int $protected
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeProtected($query, int $protected = 1)
    {
        return $query->where('protected', $protected);
    }

    /**
     * The subscribers that belong to the role.
     */
    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class, 'subscriber_fields')
            ->using(SubscriberField::class)
            ->withPivot(
                'created_at',
                'deleted_at',
                'updated_at',
                'value'
            );
    }
}
