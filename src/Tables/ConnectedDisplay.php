<?php

namespace Munkireport\Osquery\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Battery
 *
 * osquery `connected_displays` row
 *
 * @seealso https://osquery.io/schema/5.9.1/#connected_displays
 * @package Munkireport\Osquery\Tables
 */
class ConnectedDisplay extends Model
{
    public $timestamps = false;
    protected $table = 'osquery_connected_displays';

    protected $fillable = [
        'calendar_time',
        'unix_time',
        'host_identifier',
        'epoch',
        'counter',
        'numerics',

        'name',
        'product_id',
        'serial_number',
        'vendor_id',
        'manufactured_week',
        'manufactured_year',
        'display_id',
        'pixels',
        'resolution',
        'ambient_brightness_enabled',
        'connection_type',
        'display_type',
        'main',
        'mirror',
        'online',
        'rotation',
    ];

    protected $casts = [
        'main' => 'boolean',
        'mirror' => 'boolean',
        'online' => 'boolean',
    ];

    //// Relationships

    public function node()
    {
        return $this->belongsTo(
            'Munkireport\Osquery\Node',
            'osquery_node_id');
    }
}

