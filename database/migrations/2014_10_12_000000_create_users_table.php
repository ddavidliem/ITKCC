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
            $table->string('username')->unique()->require();
            $table->string('password')->hash();
            $table->string('nama_lengkap')->require();
            $table->string('alamat_email')->unique()->require();
            $table->string('tempat_lahir')->require();
            $table->date('tanggal_lahir')->require();
            $table->string('jenis_kelamin')->require();
            $table->longText('alamat')->require();
            $table->string('kota')->require();
            $table->string('kode_pos')->require();
            $table->string('nomor_telepon')->require();
            $table->string('kewarganegaraan')->require();
            $table->string('status_perkawinan')->require();
            $table->string('agama')->require();
            $table->string('pendidikan_tertinggi')->require();
            $table->string('nim')->nullable();
            $table->string('ipk')->nullable();
            $table->string('program_studi')->require();
            $table->string('disabilitas')->nullable();
            $table->string('resume')->nullable();
            $table->string('profile')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('users');
    }
};
