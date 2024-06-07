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
        Schema::create('employers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username')->unique()->length(64)->require();
            $table->string('password')->length(128)->hash();
            $table->string('nama_perusahaan')->length(128)->require();
            $table->string('alamat')->length(512)->require();
            $table->string('provinsi')->length(64)->require();
            $table->string('kota')->length(64)->require();
            $table->string('kode_pos')->length(16)->require();
            $table->string('website')->length(128)->require();
            $table->string('bidang_perusahaan')->length(128)->require();
            $table->string('tahun_berdiri')->length(16)->nullable();
            $table->string('kantor_pusat')->length(512)->nullable();
            $table->longText('deskripsi_perusahaan')->length(1024)->nullable();
            $table->string('nama_lengkap')->length(128)->require();
            $table->string('jabatan')->length(128)->require();
            $table->string('nomor_telepon')->length(32)->require();
            $table->string('alamat_email')->length(128)->require();
            $table->string('logo_perusahaan')->length(128)->nullable();
            $table->timestamp('email_verification')->length(128)->nullable();
            $table->string('google_id')->length(128)->nullable();
            $table->string('status')->length('16')->require();
            $table->longText('suspend_note')->length('1024')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('employers');
    }
};
