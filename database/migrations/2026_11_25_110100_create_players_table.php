<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->unsignedSmallInteger('birth_year')->nullable();
            $table->string('place')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });

        // Not unique (two players can share a name), but indexed for fast case-insensitive search.
        DB::statement('CREATE INDEX players_name_lower_index ON players (lower(last_name), lower(first_name))');
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
