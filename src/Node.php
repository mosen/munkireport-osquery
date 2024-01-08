<?php

namespace Munkireport\Osquery;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class Node extends Model implements Authenticatable
{
    protected $table = 'osquery_nodes';

    protected $guarded = [
        'node_key',
    ];

    //// Relationships

    public function osVersion()
    {
        return $this->hasMany(
            'Munkireport\Osquery\Tables\OsVersion',
            'osquery_node_id',
        );
    }

    public function statusLogs()
    {
        return $this->hasMany(
            'Munkireport\Osquery\NodeStatusLog',
            'osquery_node_id'
        );
    }

    public function startupItems()
    {
        return $this->hasMany(
            'Munkireport\Osquery\Tables\StartupItem',
            'osquery_node_id'
        );
    }

    public function systemInfo()
    {
        return $this->hasMany(
            'Munkireport\Osquery\Tables\SystemInfo',
            'osquery_node_id'
        );
    }

    //// Authenticatable

    public function getAuthIdentifierName()
    {
        return 'node_key';
    }

    public function getAuthIdentifier()
    {
        return $this->node_key;
    }

    public function getAuthPassword()
    {
        return $this->node_key;
    }

    public function getRememberToken()
    {
        // TODO: Implement getRememberToken() method.
    }

    public function setRememberToken($value)
    {
        // TODO: Implement setRememberToken() method.
    }

    public function getRememberTokenName()
    {
        // TODO: Implement getRememberTokenName() method.
    }
}
