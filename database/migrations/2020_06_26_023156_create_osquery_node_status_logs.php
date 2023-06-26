<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOsqueryNodeStatusLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('osquery_node_status_logs', function (Blueprint $table) {
            $table->id();

            // Logs submit their own timestamps
            // $table->timestamps();
            $table->unsignedBigInteger('osquery_node_id');
            $table->foreign('osquery_node_id')->references('id')->on('osquery_nodes');

//            $table->string('calendar_time')->nullable();
//            $table->bigInteger('unix_time')->nullable();
            $table->dateTimeTz('_timestamp');  // Derived by parsing calendar_time
            $table->string('host_identifier');
            $table->string('filename', 50)->nullable();
            $table->integer('line')->nullable();
            $table->text('message');
            $table->string('version')->nullable();

            $table->index('host_identifier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('osquery_node_status_logs');
    }
}

