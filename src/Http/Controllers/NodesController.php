<?php

namespace Munkireport\Osquery\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Munkireport\Osquery\Node;

class NodesController extends Controller
{
    public function index() {
        Inertia::setRootView('layouts.inertia');
        return Inertia::render('Nodes/Index', [
            'nodes' => Node::all(),
        ]);
    }
}
