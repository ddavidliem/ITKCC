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
            $table->string('nama_sekolah')->required();
            $table->string('tingkat_pendidikan')->required();
            $table->string('bidang_studi')->required();
            $table->string('alamat_sekolah')->required();
            $table->longText('keterangan')->nullable();
            $table->integer('tahun_lulus')->required();
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
