<?php

namespace Munkireport\Osquery\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Inertia\Response;
use Munkireport\Osquery\Node;

class NodesController extends Controller
{
    /**
     * Render a list of OSQuery Nodes.
     *
     * It assumes you have a query running for OS Version and System Info.
     *
     * @return Response
     */
    public function index(): Response
    {
        Inertia::setRootView('layouts.inertia');

        return Inertia::render('Osquery/Nodes/Index', [
            'nodes' => Node::all(),
        ]);
    }

    /**
     * View detail for a specific OSQuery Node
     *
     * It assumes you have a query running for OS Version and System Info.
     *
     * @param Node $node
     * @return Response
     */
    public function show(Node $node): Response
    {
        Inertia::setRootView('layouts.inertia');

        return Inertia::render('Osquery/Nodes/Show', [
            'node' => $node,
            'os_version' => $node->osVersion()->first(),
            'system_info' => $node->systemInfo()->first(),
        ]);
    }
}
