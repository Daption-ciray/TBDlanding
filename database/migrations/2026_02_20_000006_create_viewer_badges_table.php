<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('viewer_badges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('viewer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('badge_id')->constrained()->cascadeOnDelete();
            $table->timestamp('earned_at');

            $table->unique(['viewer_id', 'badge_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('viewer_badges');
    }
};
