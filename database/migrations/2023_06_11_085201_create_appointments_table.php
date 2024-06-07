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
        Schema::create('appointments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->dateTime('date_time')->length(64)->required();
            $table->uuid('user_id')->required();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('topik')->length(64)->required();
            $table->string('jenis_konseling')->length(32)->required();
            $table->string('tempat_konseling')->length(32)->required();
            $table->integer('jumlah_peserta')->length(16)->nullable()->default(null);
            $table->string('google_meet')->length(64)->nullable();
            $table->string('status')->length(16)->required;
            $table->longText('feedback')->length(256)->nullable();
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
        Schema::dropIfExists('appointments');
    }
};
