<?php

namespace Munkireport\Osquery\Tables;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Certificate
 *
 * osquery `certificates` row
 *
 * @seealso https://osquery.io/schema/5.9.1/#certificates
 * @package Munkireport\Osquery\Tables
 */
class Certificate extends Model
{
    public $timestamps = false;
    protected $table = 'osquery_certificates';

    protected $fillable = [
        'calendar_time',
        'unix_time',
        'host_identifier',
        'epoch',
        'counter',
        'numerics',

        'common_name',
        'subject',
        'issuer',
        'ca',
        'self_signed',
        'not_valid_before',
        'not_valid_after',
        'signing_algorithm',
        'key_algorithm',
        'key_strength',
        'key_usage',
        'subject_key_id',
        'authority_key_id',
        'sha1',
        'path',
        'serial'
    ];

    protected $casts = [
        'ca' => 'boolean',
        'self_signed' => 'boolean',
        'not_valid_before' => 'datetime',
        'not_valid_after' => 'datetime'
    ];

    //// Relationships

    public function node()
    {
        return $this->belongsTo(
            'Munkireport\Osquery\Node',
            'osquery_node_id');
    }
}
