<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOsqueryWifiStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('osquery_wifi_status', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('osquery_node_id');
            $table->foreign('osquery_node_id')->references('id')->on('osquery_nodes');

            // Boilerplate results stuff
//            $table->dateTimeTz('timestamp')->nullable();
//            $table->string('calendar_time')->nullable();
//            $table->bigInteger('unix_time');
            $table->dateTimeTz('_timestamp');  // Derived by parsing calendar_time
            $table->string('host_identifier');
            $table->unsignedInteger('epoch')->default(0);
            $table->unsignedInteger('counter')->default(0);
            $table->boolean('numerics')->nullable();

            $table->string('bssid')->nullable();
            $table->string('channel')->nullable();
            $table->string('channel_band')->nullable();
            $table->string('channel_width')->nullable();
            $table->string('country_code')->nullable();
            $table->string('interface')->nullable();
            $table->string('mode')->nullable();
            $table->string('network_name')->index('ix_osquery_wifi_status_network_name')->nullable();
            $table->integer('noise')->nullable();
            $table->integer('rssi')->nullable();
            $table->string('security_type')->nullable();
            $table->string('ssid')->nullable();
            $table->float('transmit_rate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('osquery_wifi_status');
    }
}
