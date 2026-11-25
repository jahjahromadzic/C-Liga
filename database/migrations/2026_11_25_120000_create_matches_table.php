<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->cascadeOnDelete();
            $table->foreignId('group_id')->nullable()->constrained('tournament_groups')->nullOnDelete();
            $table->string('stage', 20)->default('knockout');
            $table->unsignedTinyInteger('round');                    // 1, 2, 3...
            $table->unsignedSmallInteger('match_no')->nullable();     // order within the tournament
            $table->timestamp('scheduled_at')->nullable();
            $table->unsignedBigInteger('home_team_id');
            $table->unsignedBigInteger('away_team_id')->nullable();   // null = bye
            $table->unsignedSmallInteger('home_score')->nullable();   // null until played
            $table->unsignedSmallInteger('away_score')->nullable();
            $table->unsignedSmallInteger('home_penalties')->nullable(); // 6m shootout, čl. 4.13
            $table->unsignedSmallInteger('away_penalties')->nullable();
            $table->string('result_type', 20)->default('played');
            $table->foreignId('winner_team_id')->nullable()->constrained('teams')->restrictOnDelete();
            $table->string('status', 20)->default('scheduled');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Both teams must be registered for THIS tournament.
            $table->foreign(['tournament_id', 'home_team_id'])
                ->references(['tournament_id', 'team_id'])->on('tournament_teams')
                ->restrictOnDelete();
            $table->foreign(['tournament_id', 'away_team_id'])
                ->references(['tournament_id', 'team_id'])->on('tournament_teams')
                ->restrictOnDelete();

            $table->unique(['tournament_id', 'match_no']);
            $table->index(['tournament_id', 'round']);
        });

        DB::statement('ALTER TABLE matches ADD CONSTRAINT matches_different_teams_check
            CHECK (home_team_id <> away_team_id)');
        DB::statement('ALTER TABLE matches ADD CONSTRAINT matches_winner_is_a_team_check
            CHECK (winner_team_id IS NULL OR winner_team_id IN (home_team_id, away_team_id))');
        DB::statement('ALTER TABLE matches ADD CONSTRAINT matches_non_negative_check
            CHECK (home_score >= 0 AND away_score >= 0 AND home_penalties >= 0 AND away_penalties >= 0)');
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
