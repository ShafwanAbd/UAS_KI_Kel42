<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use phpseclib3\Crypt\DSA;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('setting', function (Blueprint $table) {
            $table->id();
            $table->text('privateKey')->nullable();
            $table->text('publicKey')->nullable();
            $table->text('encryptionKey')->nullable();
            $table->timestamps();
        });
 
        $private = DSA::createKey(2048, 160);
        $public = $private->getPublicKey();

        DB::table('setting')->insert(
            array(
                [ 
                    'privateKey' => $private,
                    'publicKey' => $public, 
                    'encryptionKey' => uniqid()
                ]
            )
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('setting');
    }
};
