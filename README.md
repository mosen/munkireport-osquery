# munkireport-osquery #

> Collect inventory from osqueryd enabled agents

This module allows you to collect inventory data from client devices running the [osquery](https://www.osquery.io/) agent.

## Features ##

* [x] **osquery** node enrollment via shared secret.
* [x] **osquery** remote logging (database storage only).
* [x] Fixed interval static queries.
* [ ] (TBD) node enrollment via TLS client certificate.
* [ ] (TBD) configurable scheduled queries via the UI.
* [ ] (TBD) ad-hoc / distributed queries via the UI.

## Module Installation ##

Require the module in your [composer.local.json](composer.local.json) file (create if it does not exist).
For example (to install from git master which will be unstable):

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
- Install the **LaunchDaemon** `/var/osquery/io.osquery.agent.plist` into `/Library/LaunchDaemons` to
  run osqueryd at startup as described in the [Post Installation Steps](https://osquery.readthedocs.io/en/latest/installation/install-macos/). 
  *NEW*: as of v5 you can simply run `osqueryctl start` as root to install the LaunchDaemon.

You will notice that the LaunchDaemon uses a flagfile located at `/private/var/osquery/osquery.flags` to
pass arguments to **osqueryd**. We will be replacing this to set up our TLS server as described
in [Remote Settings](https://osquery.readthedocs.io/en/latest/deployment/remote/).

We need the following settings:

- `--tls_hostname`
- `--enroll_tls_endpoint`, this is always `/osquery/enroll`.
- `--tls_server_certs`, especially if the server has been signed with an untrusted CA.
- An enrollment shared secret that we can use with `--enroll_secret_path`, or an environment variable specified with 
  `--enroll_secret_env`.

Your flagfile could look something like this (for a self-signed munkireport):

```shell 
--tls_hostname munkireport.hostname
--enroll_tls_endpoint /osquery/enroll
--enroll_secret_env OSQUERYD_SECRET
--config_plugin tls
--config_tls_endpoint /osquery/config
--logger_plugin tls
--logger_tls_endpoint /osquery/log
```

And you would require these flags if you are using a self-signed certificate for MunkiReport PHP:

```shell 
--tls_server_certs /path/to/a/bundle.pem
```

### Troubleshooting Enrollment ###

_NOTE_: If osquery is already running you need to stop it using `sudo osqueryctl stop`.

Run this command to enroll osqueryd interactively in the foreground so that you can
see errors being generated:

    sudo OSQUERYD_SECRET=SEKRET /opt/osquery/lib/osquery.app/Contents/MacOS/osqueryd --S \
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

Most commonly you will experience a TLS error if your server is using a self-signed certificate like below:

    tls_enroll.cpp:77] Failed enrollment request to https://munkireport.local/enroll (Request error: certificate verify failed) retrying...

osquery does not use the keychain to establish a CA trust. You must export the CA you used to sign the cert directly for usage with osquery.


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

## Development

### Installing the module locally from source

Composer allows you to have [path](https://getcomposer.org/doc/05-repositories.md#path) type repositories which install
packages based on some local path instead of fetching from a remote source.

You may use this to develop modules locally so that they do not need to be published to make changes.

You will need the following fragments in your `composer.local.json` (or `composer.json` if not using the merge plugin):

```json 
{
  "repositories": [
    {
      "type": "path",
      "url": "../munkireport-osquery"
    }
  ],
  "require": {
    "munkireport/osquery": "@dev"
  }
}
```

_NOTE_: You can see the direct dependencies of MunkiReportPHP by running `composer show -s`.

### Creating migrations when there is no dependency on Laravel

From the main app you may create a migration for a module like so:

```shell
php please make:migration --create=<table> --path=/path/to/module/database/migrations -- CreateTableName
```

