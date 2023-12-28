<?php

namespace Munkireport\Osquery\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Munkireport\Osquery\Node;

class HomeController extends Controller
{
    public function index() {
        Inertia::setRootView('osquery::layouts.inertia');
        return Inertia::render('Nodes/Index', [
            'nodes' => Node::all(),
        ]);
//        return view('osquery::home.index');
    }
}
