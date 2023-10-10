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
        Schema::create('favs', function (Blueprint $table) {
            $table->id('ID_fav');
            $table->unsignedBigInteger('ID_announce');
            $table->unsignedBigInteger('ID_user');

            $table->foreign('ID_announce')->references('ID_announce')->on('announces');
            $table->foreign('ID_user')->references('ID_user')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favs');
    }
};
