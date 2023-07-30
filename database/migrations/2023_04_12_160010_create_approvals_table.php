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
            $table->string('username')->unique()->require();
            $table->string('password')->hash();
            $table->string('nama_perusahaan')->require();
            $table->string('alamat')->require();
            $table->string('provinsi')->require();
            $table->string('kota')->require();
            $table->string('kode_pos')->require();
            $table->string('website')->require();
            $table->string('nama_lengkap')->require();
            $table->string('jabatan')->require();
            $table->string('nomor_telepon')->require();
            $table->string('alamat_email')->require();
            $table->string('formulir')->require();
            $table->string('status')->require();
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
