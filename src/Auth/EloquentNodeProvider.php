<?php


namespace Munkireport\Osquery\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Munkireport\Osquery\Contracts\NodeProvider;

class EloquentNodeProvider implements NodeProvider
{
    /**
     * The Eloquent OSQuery Node model.
     *
     * @var string
     */
    protected $model;

    /**
     * Create a new database osquery node provider.
     *
     * @param  string  $model
     * @return void
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Create a new instance of the model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createModel()
    {
        $class = '\\'.ltrim($this->model, '\\');

        return new $class;
    }

    /**
     * @inheritDoc
     */
    public function retrieveByNodeKey(string $nodeKey)
    {
        if (empty($nodeKey)) {
            return;
        }

        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        return $this->createModel()->newQuery()
            ->where('node_key', $nodeKey)
            ->first();
    }

    /**
     * @inheritDoc
     */
    public function validateNodeKey(Authenticatable $node, string $nodeKey)
    {
        // TODO: Implement validateNodeKey() method.
    }

    /**
     * Gets the name of the Eloquent user model.
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Sets the name of the Eloquent user model.
     *
     * @param  string  $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }
}
