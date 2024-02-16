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
            $table->string('username')->unique()->require();
            $table->string('password')->hash();
            $table->string('nama_perusahaan')->require();
            $table->string('alamat')->require();
            $table->string('provinsi')->require();
            $table->string('kota')->require();
            $table->string('kode_pos')->require();
            $table->string('website')->require();
            $table->string('bidang_perusahaan')->require();
            $table->string('tahun_berdiri')->nullable();
            $table->string('kantor_pusat')->nullable();
            $table->longText('deskripsi_perusahaan')->nullable();
            $table->string('nama_lengkap')->require();
            $table->string('jabatan')->require();
            $table->string('nomor_telepon')->require();
            $table->string('alamat_email')->require();
            $table->string('logo_perusahaan')->nullable();
            $table->timestamp('email_verification')->nullable();
            $table->string('google_id')->nullable();
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
