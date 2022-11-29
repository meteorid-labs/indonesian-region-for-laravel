<?php

namespace Meteor\Region\Models;

use Meteor\Region\Base\BaseModel;

class Province extends BaseModel
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
     * Get the cities for the province.
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }

    /**
     * Get the districts for the province.
     */
    public function districts()
    {
        return $this->hasManyThrough(District::class, City::class);
    }
}
