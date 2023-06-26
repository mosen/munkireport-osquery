<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOsqueryBlockDevices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('osquery_block_devices', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('osquery_node_id');
            $table->foreign('osquery_node_id')->references('id')->on('osquery_nodes');

            // Boilerplate results stuff
//            $table->string('calendar_time')->nullable();
//            $table->bigInteger('unix_time');
            $table->dateTimeTz('_timestamp');  // Derived by parsing calendar_time
            $table->string('host_identifier');
            $table->unsignedInteger('epoch')->default(0);
            $table->unsignedInteger('counter')->default(0);
            $table->boolean('numerics')->nullable();


            $table->integer('block_size')->nullable();
            $table->string('label')->nullable();
            $table->string('model')->nullable();
            $table->string('name');
            $table->string('parent')->nullable(); // This may or may not be constrained to `name` of parent.
            $table->unsignedBigInteger('size')->default(0);
            $table->string('type')->nullable();
            $table->uuid('uuid')->nullable();
            $table->string('vendor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('osquery_block_devices');
    }
}
