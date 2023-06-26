<?php

namespace Munkireport\Osquery\Contracts;

use \Illuminate\Contracts\Auth\Authenticatable;

/**
 * NodeProvider defines the contact (interface) for providing instances of OSQuery nodes, given a set of authenticated
 * credentials.
 *
 * @package App\Contacts
 */
interface NodeProvider
{
    /**
     * Retrieve a node by the given node key.
     *
     * @param  string  $nodeKey
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByNodeKey(string $nodeKey);

    /**
     * Validate a node against the given node key.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable  $node
     * @param  string  $nodeKey
     * @return bool
     */
    public function validateNodeKey(Authenticatable $node, string $nodeKey);
}
