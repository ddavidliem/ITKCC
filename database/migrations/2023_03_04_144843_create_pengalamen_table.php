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
            $table->string('title')->length(128)->required();
            $table->string('organisasi')->length(128)->required();
            $table->string('lokasi_pekerjaan')->length(256)->required();
            $table->string('tanggal_mulai')->length(32)->required();
            $table->string('tanggal_selesai')->length(32)->nullable();
            $table->longText('deskripsi')->length(512)->nullable();
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
