<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // A team's registration for one tournament (prijava ekipe).
        Schema::create('tournament_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tournament_id')->constrained()->cascadeOnDelete();
            $table->foreignId('team_id')->constrained()->restrictOnDelete();
            $table->foreignId('group_id')->nullable()->constrained('tournament_groups')->nullOnDelete();
            $table->unsignedTinyInteger('seed')->nullable();          // finals only: 1-6
            $table->boolean('has_reentry')->default(false);           // dodatna prijava, čl. 6.6
            $table->string('status', 20)->default('registered');
            $table->unsignedSmallInteger('placement')->nullable();    // filled on approval
            $table->unsignedTinyInteger('round_reached')->nullable(); // filled on approval
            $table->integer('points')->nullable();                    // snapshot on approval
            $table->foreignId('registered_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['tournament_id', 'team_id']);
            // Needed so tournament_players can reference (id, tournament_id) together.
            $table->unique(['id', 'tournament_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tournament_teams');
    }
};
