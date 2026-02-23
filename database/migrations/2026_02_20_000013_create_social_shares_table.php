<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_shares', function (Blueprint $table) {
            $table->id();
            $table->morphs('shareable');
            $table->enum('platform', ['twitter', 'instagram', 'linkedin', 'tiktok', 'other']);
            $table->string('share_url')->nullable();
            $table->unsignedInteger('points_earned')->default(0);
            $table->boolean('verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->index('platform');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_shares');
    }
};
