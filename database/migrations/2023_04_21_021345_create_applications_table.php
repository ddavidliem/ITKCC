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
        Schema::create('applications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('nama_lengkap')->length(64)->require();
            $table->string('alamat_email')->length(128)->require();
            $table->string('tempat_lahir')->length(64)->require();
            $table->date('tanggal_lahir')->length(64)->require();
            $table->string('jenis_kelamin')->length(16)->require();
            $table->longText('alamat')->length(512)->require();
            $table->string('kota')->length(64)->require();
            $table->string('kode_pos')->length(6)->require();
            $table->string('nomor_telepon')->length(32)->require();
            $table->string('kewarganegaraan')->length(8)->require();
            $table->string('status_perkawinan')->length(32)->require();
            $table->string('agama')->length(24)->require();
            $table->string('pendidikan_tertinggi')->length(24)->require();
            $table->string('nim')->length(12)->nullable();
            $table->string('ipk')->length(4)->nullable();
            $table->string('program_studi')->length(32)->require();
            $table->string('disabilitas')->length(64)->nullable();
            $table->uuid('loker_id');
            $table->foreign('loker_id')->references('id')->on('lokers');
            $table->string('status')->length(16)->nullable();
            $table->longText('feedback')->length(256)->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('applications');
        Schema::table('applications', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
