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
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->smallInteger('umur');
            $table->enum('jenis_kelamin', ['Pria', 'Wanita']);
            $table->string('alamat');
            $table->foreignId('user_id')->nullable();
            $table->foreignId('kota_id')->nullable();
            $table->foreignId('kecamatan_id')->nullable();
            $table->foreignId('kelurahan_id')->nullable();
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
        Schema::dropIfExists('karyawans');
    }
};
