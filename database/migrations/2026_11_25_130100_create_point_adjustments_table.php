<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // League points added or removed outside normal tournament scoring.
        Schema::create('point_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('season_id')->constrained()->restrictOnDelete();
            $table->foreignId('team_id')->constrained()->restrictOnDelete();
            $table->foreignId('tournament_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('points'); // + or -
            $table->string('reason', 30);
            $table->string('note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['season_id', 'team_id']);
        });

        DB::statement('ALTER TABLE point_adjustments ADD CONSTRAINT point_adjustments_nonzero_check CHECK (points <> 0)');
    }

    public function down(): void
    {
        Schema::dropIfExists('point_adjustments');
    }
};
