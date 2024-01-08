<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| OSQuery Routes
|--------------------------------------------------------------------------
|
| These routes are separated from the `api` and `web` group because OSQuery
| has specific requirements about how a node can authenticate to the remote
| configuration server. The namespace, `MR\Osquery\Http\Controllers` is set by
| the route service provider.
|
*/

// Enrollments are authenticated by TLS Client Certificate OR by a shared secret

Route::group(['prefix' => 'osquery'], function () {
    Route::post('/enroll', 'Munkireport\Osquery\Http\Controllers\EnrollController@enroll')
        ->name('osquery.enroll');

    Route::middleware(['auth:osquery'])->group(function () {
        Route::post('/config', 'Munkireport\Osquery\Http\Controllers\EndpointController@config')
            ->name('osquery.config');
        Route::post('/log', 'Munkireport\Osquery\Http\Controllers\EndpointController@log')
            ->name('osquery.log');
    });

    Route::middleware(['web', 'auth'])->group(function () {
        Route::get('/', 'Munkireport\Osquery\Http\Controllers\HomeController@index')
            ->name('osquery.home');
        Route::get('/nodes', 'Munkireport\Osquery\Http\Controllers\NodesController@index')
            ->name('osquery.nodes');
        Route::get('/nodes/{node}', 'Munkireport\Osquery\Http\Controllers\NodesController@show')
            ->name('osquery.nodes.show');
    });
});
