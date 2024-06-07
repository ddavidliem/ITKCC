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
        Schema::create('pendidikans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_sekolah')->length(128)->required();
            $table->string('tingkat_pendidikan')->length(32)->required();
            $table->string('bidang_studi')->length(64)->required();
            $table->string('alamat_sekolah')->length(256)->required();
            $table->longText('keterangan')->length(512)->nullable();
            $table->integer('tahun_lulus')->length(4)->required();
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
        Schema::dropIfExists('pendidikans');
    }
};
