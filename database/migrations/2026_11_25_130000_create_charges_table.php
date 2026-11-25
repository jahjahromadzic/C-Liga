<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Fees and fines (zaduženja).
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('season_id')->constrained()->restrictOnDelete();
            $table->foreignId('team_id')->nullable()->constrained()->restrictOnDelete();
            $table->foreignId('player_id')->nullable()->constrained()->restrictOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->restrictOnDelete(); // referee/delegate
            $table->foreignId('tournament_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('match_id')->nullable()->constrained('matches')->nullOnDelete();
            $table->string('type', 30);
            $table->decimal('amount', 10, 2);
            $table->string('description')->nullable();
            $table->string('status', 20)->default('unpaid');
            $table->timestamp('paid_at')->nullable();
            $table->string('receipt_no', 50)->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['team_id', 'status']);
            $table->index(['player_id', 'status']);
        });

        DB::statement('ALTER TABLE charges ADD CONSTRAINT charges_has_debtor_check
            CHECK (team_id IS NOT NULL OR player_id IS NOT NULL OR user_id IS NOT NULL)');
        DB::statement('ALTER TABLE charges ADD CONSTRAINT charges_amount_check CHECK (amount >= 0)');
    }

    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};
