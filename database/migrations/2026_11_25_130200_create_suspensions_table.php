<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Suspensions decided by the Radna grupa (čl. 8.16).
        // Automatic ones (3 yellow cards) are calculated from `cards`, not stored here.
        Schema::create('suspensions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('season_id')->constrained()->restrictOnDelete();
            $table->foreignId('player_id')->nullable()->constrained()->restrictOnDelete();
            $table->foreignId('team_id')->nullable()->constrained()->restrictOnDelete();
            $table->text('reason');
            $table->unsignedSmallInteger('matches')->nullable();      // number of matches
            $table->unsignedSmallInteger('tournaments')->nullable();  // number of tournaments
            $table->date('until_date')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        DB::statement('ALTER TABLE suspensions ADD CONSTRAINT suspensions_has_subject_check
            CHECK (player_id IS NOT NULL OR team_id IS NOT NULL)');
    }

    public function down(): void
    {
        Schema::dropIfExists('suspensions');
    }
};
