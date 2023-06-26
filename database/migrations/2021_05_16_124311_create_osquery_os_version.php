<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOsqueryOsVersion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('osquery_os_version', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('osquery_node_id');
            $table->foreign('osquery_node_id')->references('id')->on('osquery_nodes');

            $table->dateTimeTz('_timestamp');  // Derived by parsing calendar_time
            $table->string('host_identifier');
            $table->unsignedInteger('epoch')->default(0);
            $table->unsignedInteger('counter')->default(0);
            $table->boolean('numerics')->nullable();

            $table->string('name')->nullable();
            $table->string('version')->nullable();
            $table->unsignedMediumInteger('major')->nullable();
            $table->unsignedMediumInteger('minor')->nullable();
            $table->unsignedMediumInteger('patch')->nullable();
            $table->string('build')->nullable();
            $table->string('platform')->nullable();
            $table->string('platform_like')->nullable();
            $table->string('codename')->nullable();
            $table->string('arch')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('osquery_os_version');
    }
}
