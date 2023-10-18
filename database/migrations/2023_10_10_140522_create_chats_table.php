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
        Schema::create('chats', function (Blueprint $table) {
            $table->id('ID_message');
            $table->date('date_message')->default(now());
            $table->text('message_content');
            $table->unsignedBigInteger('ID_from');
            $table->unsignedBigInteger('ID_to');

            $table->foreign('ID_from')->references('ID_user')->on('users');
            $table->foreign('ID_to')->references('ID_user')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
