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
        Schema::create('setting_umum', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah');
            $table->string('tingkat');
            $table->string('logo')->nullable();
            $table->string('alamat')->nullable();
            $table->unsignedBigInteger('id_semester')->nullable();
            // $table->foreignId('id_semester')->constrained('semester')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('id_semester')->references('id')->on('semester')->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('setting_umum');
    }
};
