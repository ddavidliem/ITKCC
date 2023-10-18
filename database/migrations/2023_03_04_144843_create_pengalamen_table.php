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
        Schema::create('pengalamen', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->required();
            $table->string('jenis_pekerjaan')->required();
            $table->string('organisasi')->required();
            $table->string('lokasi_pekerjaan');
            $table->string('tanggal_mulai')->required();
            $table->string('tanggal_selesai')->nullable();
            $table->longText('deskripsi')->nullable();
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
        Schema::dropIfExists('pengalamen');
    }
};
