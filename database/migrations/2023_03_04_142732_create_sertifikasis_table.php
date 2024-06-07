<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sertifikasis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->length(128)->required();
            $table->string('organisasi')->length(128)->required();
            $table->string('tanggal_terbit')->length(64)->format('Y-m')->required();
            $table->string('tanggal_berakhir')->length(64)->nullable();
            $table->string('id_sertifikat')->length(128)->nullable();
            $table->string('url_sertifikat')->length(128)->nullable();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sertifikasis');
    }
};
