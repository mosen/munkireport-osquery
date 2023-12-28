<?php

namespace Munkireport\Osquery\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Munkireport\Osquery\NodeStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EndpointController extends Controller
{
    public function config(Request $request)
    {
        $node = Auth::user();
        Log::warning($node);
        Log::warning($request->getContent());

        return response()->json([
            'schedule' => config('osquery.static_schedule'),
        ]);
    }

    public function log(Request $request)
    {
        $node = Auth::user();
        Log::debug($node);
        Log::debug($request->getContent());

        $logType = $request->json('log_type');

        if ($logType === "status") {
            $data = $request->json('data');

            foreach ($data as $item) {
                $logFilename = Arr::get($item, 'filename', null);
                if (Arr::has(config('osquery.node_logging.ignore_filenames', []), $logFilename)) {
                    Log::debug("Ignored log from file: {$logFilename}");
                } else {
                    $statusLog = new NodeStatusLog();
                    $calendarTime = Arr::get($item, 'calendarTime', null);

                    // Create stored datetime from calendarTime, don't bother with Unixtime because there's no TZ
                    if ($calendarTime) {
                        // Sun May 16 11:43:03 2021 UTC
                        $timestamp = Carbon::createFromFormat('D M d H:i:s Y e', $item['calendarTime']);
                        $statusLog->_timestamp = $timestamp;
                    }

                    $statusLog->host_identifier = Arr::get($item, 'hostIdentifier', null);
                    $statusLog->filename = Arr::get($item, 'filename', null);
                    $statusLog->line = Arr::get($item, 'line', null);
                    $statusLog->message = Arr::get($item, 'message', null);
                    $statusLog->version = Arr::get($item, 'version', null);

                    $node->statusLogs()->save($statusLog);
                }
            }
        } elseif ($logType == "result") {
            $data = $request->json('data');

            foreach ($data as $item) {
                // Find a matching storage model for this query type
                Log::debug("processing result {$item['name']} using config key osquery.result_types.{$item['name']}");
                $modelName = config("osquery.result_types.{$item['name']}");
                if (!$modelName) {
                    Log::error("osquery tried to submit a result for {$item['name']} but there is no configuration to store that result type here.");
                }
                if (!class_exists($modelName)) {
                    Log::error("tried to instantiate osquery result model for query {$item['name']}, {$modelName}, but got nothing");
                }
                Log::debug("populating new instance of {$modelName}");

                $calendarTime = Arr::get($item, 'calendarTime', null);
                // Sun May 16 11:43:03 2021 UTC
                $timestamp = $calendarTime ? Carbon::createFromFormat('D M d H:i:s Y e', $item['calendarTime']) : null;

                if ($item['action'] == 'snapshot') {
                    foreach ($item['snapshot'] as $snapshot) {
                        $statusLog = new $modelName;
                        $statusLog->fill($snapshot);
                        $statusLog->_timestamp = $timestamp;
                        $statusLog->host_identifier = Arr::get($item, 'hostIdentifier', null);
                        $node->statusLogs()->save($statusLog);
                    }

                } else {
                    $statusLog = new $modelName;
                    $statusLog->fill($item['columns']);

                    $calendarTime = Arr::get($item, 'calendarTime', null);
                    if ($calendarTime) {
                        // Sun May 16 11:43:03 2021 UTC
                        $timestamp = Carbon::createFromFormat('D M d H:i:s Y e', $item['calendarTime']);
                        $statusLog->_timestamp = $timestamp;
                    }

                    $statusLog->host_identifier = Arr::get($item, 'hostIdentifier', null);

                    $node->statusLogs()->save($statusLog);
                }


            }
        } else  {
            Log::warning("Unknown log type in osquery request: ${$logType}");
        }

        // Later, we might use this to force re-enrollment
        return response()->json(['node_invalid' => false]);
    }
}
