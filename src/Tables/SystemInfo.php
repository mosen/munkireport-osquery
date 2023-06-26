<?php


namespace Munkireport\Osquery\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WifiStatus
 *
 * osquery `system_info` row
 *
 * @seealso https://osquery.io/schema/4.8.0/#system_info
 * @package Munkireport\Osquery\Tables
 */
class SystemInfo extends Model
{
    public $timestamps = false;
    protected $table = 'osquery_system_info';

    protected $fillable = [
        'hostname',
        'uuid',
        'cpu_type',
        'cpu_subtype',
        'cpu_brand',
        'cpu_physical_cores',
        'cpu_logical_cores',
        'cpu_microcode',
        'physical_memory',
        'hardware_vendor',
        'hardware_model',
        'hardware_version',
        'hardware_serial',
        'board_vendor',
        'board_version',
        'board_serial',
        'computer_name',
        'local_hostname',
    ];

    protected $casts = [

    ];

    //// Relationships

    public function node()
    {
        return $this->belongsTo(
            'Munkireport\Osquery\Node',
            'osquery_node_id');
    }
}
