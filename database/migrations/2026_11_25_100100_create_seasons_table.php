<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('year')->unique();
            $table->string('name');
            $table->string('status', 20)->default('draft');
            $table->jsonb('rules')->nullable(); // season rules, see App\Models\Season::defaultRules()
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seasons');
    }
};
