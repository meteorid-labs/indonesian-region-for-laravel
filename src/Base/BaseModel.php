<?php

namespace Meteor\Region\Base;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    /**
     * Create a new instance of the Model.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('meteor.region.database.table_prefix').$this->getTable());

        if ($connection = config('meteor.region.database.connection', false)) {
            $this->setConnection($connection);
        }
    }
}
