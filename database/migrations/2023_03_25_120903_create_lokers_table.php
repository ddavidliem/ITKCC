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
        Schema::create('lokers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_pekerjaan')->required();
            $table->string('jenis_pekerjaan')->required();
            $table->string('tipe_pekerjaan')->required();
            $table->longText('deskripsi_pekerjaan')->required();
            $table->string('lokasi_pekerjaan')->nullable();
            $table->string('poster')->nullable();
            $table->string('status')->nullable();
            $table->date('deadline')->nullable();
            $table->uuid('employer_id');
            $table->foreign('employer_id')->references('id')->on('employers');
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
        Schema::dropIfExists('lokers');
    }
};
