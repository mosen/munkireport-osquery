<?php

namespace Munkireport\Osquery\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Generic (free form/schemaless) query result storage.
 *
 * Use this to store query results when you have issued some custom query that does not relate to a built-in table.
 *
 */
class GenericResult extends Model
{
    public $timestamps = false;
    protected $table = 'osquery_generic_results';
}
