<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOsqueryConnectedDisplays extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('osquery_connected_displays', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('osquery_node_id');
            $table->foreign('osquery_node_id')->references('id')->on('osquery_nodes');

            $table->dateTimeTz('_timestamp');  // Derived by parsing calendar_time
            $table->string('host_identifier');
            $table->unsignedInteger('epoch')->default(0);
            $table->unsignedInteger('counter')->default(0);
            $table->boolean('numerics')->nullable();

            $table->string('name')->nullable();
            $table->string('product_id')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('vendor_id')->nullable();
            $table->unsignedMediumInteger('manufactured_week')->nullable();
            $table->unsignedMediumInteger('manufactured_year')->nullable();
            $table->string('display_id')->nullable();
            $table->string('pixels')->nullable();
            $table->string('resolution')->nullable();
            $table->smallInteger('ambient_brightness_enabled')->nullable();
            $table->string('connection_type')->nullable();
            $table->string('display_type')->nullable();
            $table->boolean('main')->nullable();
            $table->boolean('mirror')->nullable();
            $table->boolean('online')->nullable();
            $table->string('rotation')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('osquery_connected_displays');
    }
}
