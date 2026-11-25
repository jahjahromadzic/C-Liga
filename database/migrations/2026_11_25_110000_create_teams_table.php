<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('representative_name')->nullable();
            $table->string('representative_phone', 30)->nullable();
            $table->string('place')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_verified')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Team names are unique regardless of letter case ("Bratstvo Gata" = "bratstvo gata").
        DB::statement('CREATE UNIQUE INDEX teams_name_lower_unique ON teams (lower(name))');
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
