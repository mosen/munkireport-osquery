<?php


namespace Munkireport\Osquery\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WifiStatus
 *
 * osquery `wifi_status` row
 *
 * @seealso https://osquery.io/schema/4.8.0/#wifi_status
 * @package Munkireport\Osquery\Tables
 */
class WifiStatus extends Model
{
    public $timestamps = false;
    protected $table = 'osquery_wifi_status';

    protected $fillable = [
        'bssid',
        'channel',
        'channel_band',
        'channel_width',
        'country_code',
        'interface',
        'mode',
        'network_name',
        'noise',
        'rssi',
        'security_type',
        'ssid',
        'transmit_rate',
    ];

    protected $casts = [
        'transmit_rate' => 'float',
        'noise' => 'int',
        'rssi' => 'int',
    ];

    //// Relationships

    public function node()
    {
        return $this->belongsTo(
            'Munkireport\Osquery\Node',
            'osquery_node_id');
    }
}
