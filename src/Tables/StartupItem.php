<?php

namespace Munkireport\Osquery\Tables;

use Illuminate\Database\Eloquent\Model;

class StartupItem extends Model
{
    public $timestamps = false;
    protected $table = 'osquery_startup_items';

    protected $fillable = [
        'calendar_time',
        'unix_time',
        'host_identifier',
        'epoch',
        'counter',
        'numerics',
        'args',
        'name',
        'path',
        'source',
        'status',
        'type',
        'username',
    ];

    //// Relationships

    public function node()
    {
        return $this->belongsTo(
            'Munkireport\Osquery\Node',
            'osquery_node_id');
    }
}
