<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quest_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quest_id')->constrained()->cascadeOnDelete();
            $table->morphs('completable');
            $table->string('proof_url')->nullable();
            $table->unsignedInteger('xp_earned')->default(0);
            $table->unsignedInteger('credits_earned')->default(0);
            $table->timestamp('completed_at');

            $table->unique(['quest_id', 'completable_type', 'completable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quest_completions');
    }
};
