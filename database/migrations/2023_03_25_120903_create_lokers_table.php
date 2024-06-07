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
            $table->string('nama_pekerjaan')->length(128)->required();
            $table->string('jenis_pekerjaan')->length(64)->required();
            $table->string('tipe_pekerjaan')->length(64)->required();
            $table->longText('deskripsi_pekerjaan')->length(2048)->required();
            $table->string('lokasi_pekerjaan')->length(512)->nullable();
            $table->string('poster')->nullable();
            $table->string('status')->length(16)->nullable();
            $table->longText('suspend_note')->length(1024)->nullable();
            $table->date('deadline')->nullable();
            $table->uuid('employer_id');
            $table->foreign('employer_id')->references('id')->on('employers');
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
        Schema::dropIfExists('lokers');
        Schema::table('lokers', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
