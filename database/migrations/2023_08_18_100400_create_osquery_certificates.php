<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOsqueryCertificates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('osquery_certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('osquery_node_id');
            $table->foreign('osquery_node_id')->references('id')->on('osquery_nodes');

            $table->dateTimeTz('_timestamp');  // Derived by parsing calendar_time
            $table->string('host_identifier');
            $table->unsignedInteger('epoch')->default(0);
            $table->unsignedInteger('counter')->default(0);
            $table->boolean('numerics')->nullable();

            $table->string('common_name')->nullable()->index('ix_certificate_common_name');
            $table->string('subject')->nullable()->index('ix_certificate_subject');
            $table->string('issuer')->nullable();
            $table->boolean('ca')->nullable();
            $table->boolean('self_signed')->nullable();
            $table->dateTimeTz('not_valid_before')->nullable();
            $table->dateTimeTz('not_valid_after')->nullable()->index('ix_certificate_not_valid_after');
            $table->string('signing_algorithm')->nullable();
            $table->string('key_algorithm')->nullable();
            $table->string('key_strength')->nullable();
            $table->string('key_usage')->nullable();
            $table->string('subject_key_id')->nullable();
            $table->string('authority_key_id')->nullable();
            $table->string('sha1')->nullable();
            $table->string('path')->nullable();
            $table->string('serial')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('osquery_certificates');
    }
}
