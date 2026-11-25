<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // A team's roster at one tournament (spisak igrača).
        Schema::create('tournament_players', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tournament_team_id');
            $table->unsignedBigInteger('tournament_id'); // copy of the registration's tournament
            $table->foreignId('player_id')->constrained()->restrictOnDelete();
            $table->unsignedTinyInteger('shirt_number')->nullable();
            $table->boolean('is_paid_extra')->default(false); // player over the free limit, čl. 10.11
            $table->timestamps();

            // Composite foreign key: (tournament_team_id, tournament_id) must match a real
            // registration, so tournament_id can never disagree with the registration.
            $table->foreign(['tournament_team_id', 'tournament_id'])
                ->references(['id', 'tournament_id'])
                ->on('tournament_teams')
                ->cascadeOnDelete();

            // čl. 11.6: a player can play for only one team per tournament.
            $table->unique(['tournament_id', 'player_id']);

            // Shirt numbers are unique within a team's roster (NULLs are allowed many times).
            $table->unique(['tournament_team_id', 'shirt_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournament_players');
    }
};
