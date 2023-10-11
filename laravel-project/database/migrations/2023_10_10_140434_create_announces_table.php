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
        Schema::create('announces', function (Blueprint $table) {
            $table->id('ID_announce');
            $table->string('title', 255);
            $table->integer('price');
            $table->text('description');
            $table->boolean('available');
            $table->date('date_announce')->default(now());
            $table->string('type', 5);
            $table->date('year');
            $table->float('length');
            $table->float('width');
            $table->integer('power');
            $table->integer('engines');
            $table->string('fuel', 9);
            $table->string('flag', 50);
            $table->unsignedBigInteger('ID_location');
            $table->unsignedBigInteger('ID_user');

            $table->foreign('ID_location')->references('ID_location')->on('locations');
            $table->foreign('ID_user')->references('ID_user')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announces');
    }
};
