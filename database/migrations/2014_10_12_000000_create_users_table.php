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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username')->unique()->length(64)->require();
            $table->string('password')->hash()->length(128)->require();
            $table->string('nama_lengkap')->length(128)->require();
            $table->string('alamat_email')->length(128)->unique()->require();
            $table->string('tempat_lahir')->length(64)->require();
            $table->date('tanggal_lahir')->require();
            $table->string('jenis_kelamin')->length(8)->require();
            $table->longText('alamat')->length(512)->require();
            $table->string('kota')->length(64)->require();
            $table->string('kode_pos')->length(6)->require();
            $table->string('nomor_telepon')->length(16)->require();
            $table->string('kewarganegaraan')->length(4)->require();
            $table->string('status_perkawinan')->length(32)->require();
            $table->string('agama')->length(64)->require();
            $table->string('pendidikan_tertinggi')->length(16)->require();
            $table->string('nim')->length(12)->nullable();
            $table->string('ipk')->length(4)->nullable();
            $table->string('program_studi')->references('program_studi')->on('prodis')->length(32)->require();
            $table->string('disabilitas')->length(64)->nullable();
            $table->string('resume')->length(64)->nullable();
            $table->string('profile')->length(64)->nullable();
            $table->timestamp('email_verification')->length(64)->nullable();
            $table->string('status')->length(16)->require();
            $table->longText('suspend_note')->length(1024)->nullable();
            $table->string('google_id')->length(128)->nullable();
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
        Schema::dropIfExists('users');
    }
};
