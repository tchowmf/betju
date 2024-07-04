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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('player1');
            $table->string('player2');
            $table->integer('loser_games')->nullable();
            $table->enum('status', ['ativo', 'inativo', 'resolvido', 'cancelado']);
            $table->timestamp('time_limit')->nullable();
            $table->enum('winner', ['player1', 'player2'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
