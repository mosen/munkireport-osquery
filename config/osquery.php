<?php


return [
    /*
     |===============================================
     | Shared Enrollment Secret
     |===============================================
     |
     | When using shared secret enrollment, this will be
     | the 'Default' secret to enroll osquery nodes.
     |
     | If machine groups or business units are enabled,
     | each will have their own enrollment secret.
     */
    'shared_secret' => env('OSQUERY_SHARED_SECRET', ''),

    /*
     |===============================================
     | Default Query Schedule Frequency/Interval
     |===============================================
     |
     | The default interval (in seconds) between running
     | queries, if the query does not specify an interval.
     */
    'default_interval' => (int)env('OSQUERY_DEFAULT_INTERVAL', 10),


    /*
     |===============================================
     | Static Query Schedule
     |===============================================
     |
     | These queries will be run completely regardless of individual
     | node configuration. This gives you an easy way to insert new
     | queries without worrying about group filtering/inheritance and
     | merging.
     |
     | NOTE: query names may be reserved by munkireport if they start with mr_*,
     | so don't use the mr_ prefix in any of your custom queries.
     */
    'static_schedule' => [
        'block_devices' => [
            'query' => 'SELECT * FROM block_devices;',
            'interval' => 60 * 60 * 24 * 1, // One per day very unlikely to change
            'platform' => 'darwin',
        ],
        'certificates' => [
            'query' => 'SELECT * FROM certificates;',
            'interval' => 60 * 60, // One per hour, can vary
        ],
        'connected_displays' => [
            'query' => 'SELECT * FROM connected_displays;',
            'interval' => 60 * 60 * 24 * 1, // One per day very unlikely to change
            'platform' => 'darwin',
        ],
        'os_version' => [
            'query' => 'SELECT * FROM os_version;',
            'interval' => 60 * 60 * 24 * 1, // One per day very unlikely to change
            'platform' => 'darwin',
        ],
        'startup_items' => [
            'query' => 'SELECT * FROM startup_items;',
            'interval' => 60 * 60, // One per hour, can vary
            'platform' => 'darwin',
        ],
        'system_info' => [
            'query' => 'SELECT * FROM system_info;',
            'interval' => 60 * 60 * 24 * 1, // One per day very unlikely to change
        ],
        'wifi_status' => [
            'query' => 'SELECT * FROM wifi_status;',
            'interval' => 60 * 60, // One per hour, can vary
            'platform' => 'darwin',
        ]
    ],

    /*
     |===============================================
     | Query Result to Model Mapping
     |===============================================
     |
     | WARNING: Don't change this unless you know what you're doing.
     |
     | For each statically defined query you need an Eloquent model
     | to store the result of the query. This array defines the result model required
     | to store the static query with the same name.
     |
     | The model class given will be updated with the `columns` dict in the osquery response.
     |
     */
    'result_types' => [
        'block_devices' => \Munkireport\Osquery\Tables\BlockDevice::class,
        'certificates' => \Munkireport\Osquery\Tables\Certificate::class,
        'connected_displays' => \Munkireport\Osquery\Tables\ConnectedDisplay::class,
        'os_version' => \Munkireport\Osquery\Tables\OsVersion::class,
        'startup_items' => \Munkireport\Osquery\Tables\StartupItem::class,
        'system_info' => \Munkireport\Osquery\Tables\SystemInfo::class,
        'wifi_status' => \Munkireport\Osquery\Tables\WifiStatus::class,
    ],

    /*
     |===============================================
     | Static Query Packs
     |===============================================
     |
     | These packs will be run on every node, similar to
     | the static schedule.
     */
    'static_packs' => [

    ],


    'static_file_paths' => [

    ],


    /*
     |===============================================
     | Node Logging Level
     |===============================================
     |
     | By default, nodes log a very large amount of debug messaging depending on
     | their client configuration. This mechanism provides a way of keeping logs
     | tidy even if they are misconfigured.
     */
    'node_logging' => [
        'ignore_filenames' => [
            'tls.cpp' // The logging TLS plugin creates a huge amount of useless messages
        ]
    ],
];
