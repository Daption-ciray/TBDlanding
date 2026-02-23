<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tester_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('xp_cost');
            $table->enum('status', ['pending', 'testing', 'completed', 'cancelled'])->default('pending');
            $table->text('feedback')->nullable();
            $table->unsignedSmallInteger('rating')->nullable();
            $table->timestamp('tested_at')->nullable();
            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tester_requests');
    }
};
