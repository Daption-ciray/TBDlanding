<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('card_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->foreignId('card_id')->constrained()->cascadeOnDelete();
            $table->foreignId('target_team_id')->nullable()->constrained('teams')->nullOnDelete();
            $table->unsignedInteger('credits_spent');
            $table->timestamp('purchased_at');
            $table->timestamp('used_at')->nullable();
            $table->json('result_data')->nullable();

            $table->index('team_id');
            $table->index('target_team_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('card_purchases');
    }
};
