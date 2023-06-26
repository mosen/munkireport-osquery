<?php


namespace Munkireport\Osquery\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BlockDevice
 *
 * osquery `block_devices` row

 * @seealso https://osquery.io/schema/4.8.0/#block_devices
 * @package Munkireport\Osquery\Tables
 */
class BlockDevice extends Model
{
    public $timestamps = false;
    protected $table = 'osquery_block_devices';

    protected $fillable = [
        'calendar_time',
        'unix_time',
        'host_identifier',
        'epoch',
        'counter',
        'numerics',

        'block_size',
        'label',
        'model',
        'name',
        'parent',
        'type',
        'uuid',
        'vendor'
    ];

    //// Relationships

    public function node()
    {
        return $this->belongsTo(
            'Munkireport\Osquery\Node',
            'osquery_node_id');
    }
}
