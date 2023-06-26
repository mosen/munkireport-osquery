<?php

namespace Munkireport\Osquery\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Munkireport\Osquery\Http\Requests\EnrollmentRequest;
use Munkireport\Osquery\Node;

/**
 * OSQuery Enrollment Endpoint
 *
 * @package App\Http\Controllers
 */
class EnrollController extends Controller
{
    /**
     * Enroll a new node into the OSQuery service on MunkiReport (using the shared secret strategy).
     *
     * The node POSTs it's shared secret to this endpoint and expects that we will return a node key, which it
     * uses for the rest of its lifetime.
     *
     * @param EnrollmentRequest $request The HTTP request which is validated to be an osquery enrollment request.
     * @return null
     * @todo time-limited enroll secrets which are rotated.
     * @todo separate enroll secrets for business units to allow direct enrollment into those business units.
     */
    public function enroll(Request $request)
    {
        Log::info(json_encode($request->json()));
        Log::error($request->json('enroll_secret'));
        Log::error($request->getContent());

        $enrollSecret = $request->json('enroll_secret');
        if ($enrollSecret !== config('osquery.shared_secret')) {
            Log::warning('an osquery node attempted to enroll with an invalid secret',
                ['remote_ip' => $request->getClientIp()]);
            return null;
        }

        $node = new Node([
            'host_identifier' => $request->json('host_identifier'),
            'config_hash' => $request->json('host_details.osquery_info.config_hash', null),
            'config_valid' => $request->json('host_details.osquery_info.config_valid', null),
            'extensions' => $request->json('host_details.osquery_info.extensions', null),
            'instance_id' => $request->json('host_details.osquery_info.instance_id', null),
            'pid' => intval($request->json('host_details.osquery_info.pid', 0)),
            'platform_mask' => $request->json('host_details.osquery_info.platform_mask', null),
            'start_time' => $request->json('host_details.osquery_info.start_time', null),
        ]);

        $node->node_key = (string) Str::uuid();

        if ($node->save()) {
            return response()->json([
                "node_key" => $node->node_key,
                "node_invalid" => false,
            ]);
        } else {
            return response()->json([
                "node_key" => "",
                "node_invalid" => true,
            ]);
        }
    }
}
