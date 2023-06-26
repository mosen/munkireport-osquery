<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOsqueryStartupItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('osquery_startup_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('osquery_node_id');
            $table->foreign('osquery_node_id')->references('id')->on('osquery_nodes');

            // Boilerplate results stuff
//            $table->string('calendar_time')->nullable();
//            $table->timestamp('unix_time');
            $table->dateTimeTz('_timestamp');  // Derived by parsing calendar_time
            $table->string('host_identifier');
            $table->unsignedInteger('epoch')->default(0);
            $table->unsignedInteger('counter')->default(0);
            $table->boolean('numerics')->nullable();

            $table->string('args')->nullable();
            $table->string('name')->nullable();
            $table->string('path')->nullable();
            $table->string('source')->nullable();
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->string('username')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('osquery_startup_items');
    }
}
