<?php

namespace Meteor\Region\Models;

use Meteor\Region\Base\BaseModel;

class District extends BaseModel
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
     * Get the city that owns the district.
     */
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Get the villages for the district.
     */
    public function villages()
    {
        return $this->hasMany(Village::class);
    }
}
