<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOsquerySystemInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('osquery_system_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('osquery_node_id');
            $table->foreign('osquery_node_id')->references('id')->on('osquery_nodes');

            $table->dateTimeTz('_timestamp');  // Derived by parsing calendar_time
            $table->string('host_identifier');
            $table->unsignedInteger('epoch')->default(0);
            $table->unsignedInteger('counter')->default(0);
            $table->boolean('numerics')->nullable();

            $table->string('hostname')->nullable();
            $table->uuid('uuid')->nullable();
            $table->string('cpu_type')->nullable();
            $table->string('cpu_subtype')->nullable();
            $table->string('cpu_brand')->nullable();
            $table->unsignedMediumInteger('cpu_physical_cores')->nullable();
            $table->unsignedMediumInteger('cpu_logical_cores')->nullable();
            $table->string('cpu_microcode')->nullable();
            $table->unsignedBigInteger('physical_memory')->nullable();
            $table->string('hardware_vendor')->nullable();
            $table->string('hardware_model')->index('ix_osquery_system_info_hardware_model')->nullable();
            $table->string('hardware_version')->nullable();
            $table->string('hardware_serial')->index('ix_osquery_system_info_hardware_serial')->nullable();
            $table->string('board_vendor')->nullable();
            $table->string('board_version')->nullable();
            $table->string('board_serial')->nullable();
            $table->string('computer_name')->nullable();
            $table->string('local_hostname')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('osquery_system_info');
    }
}
