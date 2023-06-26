<?php


namespace Munkireport\Osquery\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OsVersion
 *
 * osquery `os_version` row
 *
 * @seealso https://osquery.io/schema/4.8.0/#os_version
 * @package Munkireport\Osquery\Tables
 */
class OsVersion extends Model
{
    public $timestamps = false;
    protected $table = 'osquery_os_version';

    protected $fillable = [
        'name',
        'version',
        'major',
        'minor',
        'patch',
        'build',
        'platform',
        'platform_like',
        'codename',
        'arch',
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
