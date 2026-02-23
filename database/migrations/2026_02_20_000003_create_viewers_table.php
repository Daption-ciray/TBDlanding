<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('viewers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->unsignedInteger('total_watch_minutes')->default(0);
            $table->unsignedInteger('xp')->default(0);
            $table->unsignedSmallInteger('current_streak')->default(0);
            $table->timestamp('last_seen_at')->nullable();
            $table->string('session_token', 64)->unique()->nullable();
            $table->timestamps();

            $table->index('xp');
            $table->index('total_watch_minutes');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('viewers');
    }
};
