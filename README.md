# munkireport-osquery #

> Collect inventory from osqueryd enabled agents

## Module Installation ##

Require the module in your [composer.local.json](composer.local.json) file (create if it does not exist).
For example:

    COMPOSER=composer.local.json composer require mosen/munkireport-osquery:dev-master

To verify that the module has been installed correctly you could list the available routes:

    $ php please route:list --name=osquery

Which should return the new URL's for config, enroll and log endpoints, something like this:

    POST       osquery/config 
    POST       osquery/enroll 
    POST       osquery/log 

## Module Configuration ##

Publish the default configuration file by running:

    php please vendor:publish --tag=config

This should copy a brand-new config file, osquery.php, into the `config/` directory for you to customise, or override
with your .env file.

To override the enrollment secret, you may place the following into your `.env` file or environment:

    OSQUERY_SHARED_SECRET="<secret goes here>"

## Agent Installation ##

- Install the [osquery package for macOS](https://osquery.readthedocs.io/en/latest/installation/install-macos/),
  packages are available [here](https://osquery.io/downloads/). MunkiReport will not
  do this for you (It isn't a software distribution system).
- Install the **LaunchDaemon** `/var/osquery/com.facebook.osqueryd.plist` into `/Library/LaunchDaemons` to
  run osqueryd at startup as described in the [Post Installation Steps](https://osquery.readthedocs.io/en/latest/installation/install-macos/).

You will notice that the LaunchDaemon uses a flagfile located at `/private/var/osquery/osquery.flags` to
pass arguments to **osqueryd**. We will be replacing this to set up our TLS server as described
in [Remote Settings](https://osquery.readthedocs.io/en/latest/deployment/remote/).

We need the following settings:

- `--tls_hostname`
- `--enroll_tls_endpoint`, this is always `https://<munkireport-url>/osquery/enroll`.
- `--tls_server_certs`, especially if the server has been signed with an untrusted CA.
- An enrollment shared secret that we can use with `--enroll_secret_path`.

### Troubleshooting Enrollment ###

Run this command to enroll osqueryd interactively in the foreground so that you can
see errors being generated:

    sudo OSQUERYD_SECRET=SEKRET osqueryd --S \
      --allow_unsafe=true \
      --tls_hostname munkireport.hostname \
      --enroll_tls_endpoint /osquery/enroll \
      --enroll_secret_env OSQUERYD_SECRET \
      --config_plugin tls \
      --config_tls_endpoint /osquery/config \
      --tls_server_certs /path/to/a/bundle.pem \
      --logger_plugin tls \
      --logger_tls_endpoint /osquery/log


If you need to test enrollment you may use:

      --enroll_always 

Which forces a re-enrollment every time you run the osquery daemon.

### Enrollment via TLS Client Auth ###

Sorry, TLS client cert authentication is not yet supported.

## Architecture

### Machine Authentication

Machines within osquery may be authenticated using mTLS (Not Supported Yet), or a Shared Secret.

For the shared secret method, a new auth guard, called "osquery" is added into config/auth.php in MunkiReport PHP:

        'osquery' => [
            'driver' => 'nodekey',
            'provider' => 'nodes',
        ],

This allows certain osquery endpoints to accept osquery style shared secret auth.

To correlate a specific node with its key, we also need to add a new auth provider, called "nodes"

        'nodes' => [
            'driver' => 'eloquent',
            'model' => Munkireport\Osquery\Node::class,
        ]

This will tie each specific node to an Eloquent ORM Model / Database table row which identifies that node.

### Query Schedule

So far, we only support queries via config file. The queries are exactly identical for any node running osqueryd.

You can edit or add queries to config/osquery.php in order to collect more or less data from osquery.

