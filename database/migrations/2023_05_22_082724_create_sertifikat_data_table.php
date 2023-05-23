<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sertifikat_data', function (Blueprint $table) {
            $table->id();
            $table->string('uniqueId'); 
            $table->string('noPeserta');
            $table->string('nama');
            $table->string('instansi');
            $table->string('tanggalTerbit');
            $table->string('noSertifikat');
            $table->string('namaPelatihan');
            $table->string('keikutsertaan'); 
            $table->binary('encryptedMessage'); 
            $table->binary('sign')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifikat_data');
    }
};
