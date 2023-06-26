<?php

namespace Munkireport\Osquery\Auth;


use Illuminate\Support\Facades\Log;
use Munkireport\Osquery\Contracts\NodeProvider;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard as Guard;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

/**
 * NodeKeyGuard implements the `node_key` authentication mechanism for OSQuery nodes using this service as a remote
 * configuration or log server.
 *
 * @see https://osquery.readthedocs.io/en/stable/deployment/remote/#remote-authentication
 * @package App\Auth
 */
class NodeKeyGuard implements Guard
{
    /**
     * The name of the Guard. Typically "nodekey".
     *
     * Corresponds to guard name in authentication configuration.
     *
     * @var string
     */
    protected $name;

    /**
     * @var NodeProvider
     */
    protected $provider;

    /**
     * The request instance.
     *
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    public function __construct($name,
                                NodeProvider $provider,
                                Request $request = null) {
        $this->name = $name;
        $this->provider = $provider;
        $this->request = $request;
    }

    /**
     * @inheritDoc
     */
    public function check()
    {
        if (!$this->request->json('node_key')) {
            Log::warning('Attempt to access protected Osquery Endpoint without a node key denied');
            return false;
        }

        $node = $this->user();
        if (!$node) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @inheritDoc
     */
    public function guest()
    {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function user()
    {
        if (!$this->request->json('node_key')) {
            Log::warning('Attempt to access protected Osquery Endpoint without a node key denied');
            return null;
        }

        return $this->provider->retrieveByNodeKey($this->request->json('node_key'));
    }

    /**
     * @inheritDoc
     */
    public function id()
    {
        $node = $this->user();
        if (!$node) {
            return null;
        }

        return $node->getAuthIdentifier();
    }

    /**
     * @inheritDoc
     */
    public function validate(array $credentials = [])
    {
        // TODO: Implement validate() method.
    }

    /**
     * @inheritDoc
     */
    public function setUser(Authenticatable $user)
    {
        // TODO: Implement setUser() method.
    }
}
