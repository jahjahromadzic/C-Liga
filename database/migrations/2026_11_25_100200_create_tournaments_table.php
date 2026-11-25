<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tournaments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('season_id')->constrained()->restrictOnDelete();
            $table->foreignId('delegate_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedSmallInteger('ordinal'); // number in the season calendar
            $table->string('type', 20)->default('regular');
            $table->string('format', 30)->default('knockout');
            $table->string('name');
            $table->string('location');
            $table->date('starts_on');
            $table->date('ends_on');
            $table->string('organizer_name')->nullable();
            $table->string('organizer_phone', 30)->nullable();
            $table->decimal('prize_fund', 10, 2)->nullable();
            $table->decimal('entry_fee', 10, 2)->nullable();
            $table->unsignedTinyInteger('match_minutes')->default(20);
            $table->string('status', 20)->default('planned');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['season_id', 'ordinal']);
        });

        DB::statement('ALTER TABLE tournaments ADD CONSTRAINT tournaments_dates_check CHECK (ends_on >= starts_on)');
    }

    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
