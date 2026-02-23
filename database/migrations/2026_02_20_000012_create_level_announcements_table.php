<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('level_announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('viewer_id')->nullable()->constrained()->nullOnDelete();
            $table->string('message');
            $table->enum('type', ['level_up', 'badge_earned', 'quest_complete', 'card_used', 'tester_called', 'trade_complete', 'social_share', 'system']);
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index('created_at');
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('level_announcements');
    }
};
