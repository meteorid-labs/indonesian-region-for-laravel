<?php

namespace Meteor\Region\Models;

use Meteor\Region\Base\BaseModel;

class City extends BaseModel
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'code';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the province that owns the city.
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Get the districts for the city.
     */
    public function districts()
    {
        return $this->hasMany(District::class);
    }

    /**
     * Get the villages for the city.
     */
    public function villages()
    {
        return $this->hasManyThrough(Village::class, District::class);
    }
}
