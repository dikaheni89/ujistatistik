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
        Schema::create('bapenda_sheet1', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resource_id')->index();
            $table->integer('kode_kabupaten');
            $table->string('nama_kabupaten');
            $table->string('jenis_pajak_daerah')->nullable();
            $table->year('tahun');
            $table->string('jumlah_target')->nullable();
            $table->string('satuan');
            $table->timestamps();

            $table->foreign('resource_id')->references('id')->on('resources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bapenda_sheet1');
    }
};
