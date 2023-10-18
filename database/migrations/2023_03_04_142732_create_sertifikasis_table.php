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
        Schema::create('sertifikasis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->required();
            $table->string('organisasi')->required();
            $table->string('tanggal_terbit')->format('Y-m')->required();
            $table->string('tanggal_berakhir')->nullable();
            $table->string('id_sertifikat')->nullable();
            $table->string('url_sertifikat')->nullable();
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
        Schema::dropIfExists('sertifikasis');
    }
};
