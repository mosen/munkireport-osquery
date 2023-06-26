<?php
namespace Munkireport\Osquery\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Munkireport\Osquery\Auth\EloquentNodeProvider;
use Munkireport\Osquery\Auth\NodeKeyGuard;
use Munkireport\Osquery\Node;

class ModuleServiceProvider extends ServiceProvider
{
    // boot
//Auth::extend('nodekey', function ($app, $name, array $config) {
//    return new NodeKeyGuard($name, new EloquentNodeProvider(Node::class), request());
//});

    public function boot()
    {
        $packageDir = realpath(__DIR__.'/../../');

        $this->publishes([
            $packageDir . '/config/osquery.php' => config_path('osquery.php'),
        ], 'config');
        $this->loadMigrationsFrom($packageDir . '/database/migrations');
        $this->loadRoutesFrom($packageDir . '/routes/osquery.php');
        $this->loadTranslationsFrom($packageDir . '/resources/lang', 'osquery');
        $this->loadViewsFrom($packageDir . '/resources/views', 'osquery');

        if ($this->app->runningInConsole()) {
//            $this->commands([
//                JamfSyncCommand::class,
//                JamfListComputersCommand::class,
//            ]);
        }

        Auth::extend('nodekey', function ($app, $name, array $config) {
            return new NodeKeyGuard($name, new EloquentNodeProvider(Node::class), request());
        });

//        Auth::provider('nodes', function ($app, array $config) {
//           return new EloquentNodeProvider(Node::class);
//        });
    }

    public function register()
    {
        parent::register();
//        $this->app->bind(Jamf::class, function($app) {
//            return new Jamf();
//        });
    }
}
