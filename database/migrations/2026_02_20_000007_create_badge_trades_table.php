<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('badge_trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_team_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignId('to_team_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignId('badge_id')->constrained()->cascadeOnDelete();
            $table->foreignId('offered_badge_id')->nullable()->constrained('badges')->nullOnDelete();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'cancelled'])->default('pending');
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('badge_trades');
    }
};
