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
        Schema::create('approvals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username')->unique()->length(64)->require();
            $table->string('password')->length(64)->hash();
            $table->string('nama_perusahaan')->length(128)->require();
            $table->string('alamat')->length(512)->require();
            $table->string('provinsi')->length(64)->require();
            $table->string('kota')->length(64)->require();
            $table->string('kode_pos')->length(6)->require();
            $table->string('website')->length(128)->require();
            $table->string('bidang_perusahaan')->length(128)->require();
            $table->string('tahun_berdiri')->length(4)->nullable();
            $table->string('kantor_pusat')->length(256)->nullable();
            $table->string('nama_lengkap')->length(128)->require();
            $table->string('jabatan')->length(128)->require();
            $table->string('nomor_telepon')->length(32)->require();
            $table->string('alamat_email')->length(128)->require();
            $table->string('formulir')->require();
            $table->string('status')->length(16)->require();
            $table->longText('feedback')->length(1024)->nullable();
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
        Schema::dropIfExists('approvals');
    }
};
