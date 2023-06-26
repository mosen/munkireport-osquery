<?php

namespace Munkireport\Osquery;

use Illuminate\Database\Eloquent\Model;

class NodeStatusLog extends Model
{
    protected $table = 'osquery_node_status_logs';

    protected $fillable = [
        'calendar_time',
        'unix_time',
        'host_identifier',
        'filename',
        'line',
        'message',
        'version',
    ];

    // osquery sends timestamps with the log information, and we don't necessarily want to have our own.
    public $timestamps = false;

    protected $casts = [
        'unix_time' => 'int',
    ];

    //// Relationships

    public function node()
    {
        return $this->belongsTo(
            'Munkireport\Osquery\Node',
            'osquery_node_id');
    }
}
