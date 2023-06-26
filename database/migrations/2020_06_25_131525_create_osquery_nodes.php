<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOsqueryNodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('osquery_nodes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('host_identifier', 255);
            $table->uuid('node_key');

            // `osquery_info` keys
            $table->string('config_hash')->nullable();
            $table->string('config_valid')->nullable();
            $table->string('extensions')->nullable();
            $table->string('instance_id')->nullable();
            $table->integer('pid')->nullable();
            $table->string('platform_mask')->nullable();
            $table->string('start_time')->nullable();
            $table->string('uuid')->nullable();
            $table->string('version')->nullable();
            $table->string('watcher')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('osquery_nodes');
    }
}
