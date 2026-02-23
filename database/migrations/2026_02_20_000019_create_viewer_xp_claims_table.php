<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('viewer_xp_claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('viewer_id')->constrained('viewers')->cascadeOnDelete();
            $table->string('claim_type', 50)->default('social_share'); // social_share, other
            $table->string('platform', 50); // twitter, instagram, linkedin, tiktok, other
            $table->unsignedSmallInteger('points_requested');
            $table->string('proof_path', 500); // storage path to image
            $table->string('share_url', 500)->nullable();
            $table->string('status', 20)->default('pending'); // pending, approved, rejected
            $table->timestamp('reviewed_at')->nullable();
            $table->unsignedBigInteger('reviewed_by')->nullable(); // optional user/sura id
            $table->string('rejection_reason', 500)->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index('viewer_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('viewer_xp_claims');
    }
};
