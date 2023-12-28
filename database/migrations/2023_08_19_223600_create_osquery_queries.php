<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOsqueryQueries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('osquery_queries', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('enabled')->default(true);
            $table->text('query');
            $table->unsignedBigInteger('interval'); // in seconds (can be splayed)
            $table->boolean('removed')->nullable();
            $table->string('platform')->nullable();
            $table->string('version')->nullable();
            $table->unsignedInteger('shard')->nullable();
            $table->boolean('denylist')->nullable();

            $table->string('result_key')->unique('uq_osquery_queries_result_key');
            $table->boolean('is_discovery')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('osquery_queries');
    }
}
