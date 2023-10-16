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
        Schema::create('users', function (Blueprint $table) {
            $table->id('ID_user');
            $table->string('nickname', 50);
            $table->string('mail', 70);
            $table->string('password', 50);
            $table->string('phone_number', 20);
            $table->string('profile_picture', 30);
            $table->string('profile_type', 13);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
