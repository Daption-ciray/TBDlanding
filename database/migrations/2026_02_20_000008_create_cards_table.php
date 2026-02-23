<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('type', ['lutuf', 'gazap']);
            $table->text('description');
            $table->text('effect_description');
            $table->json('effect_data')->nullable();
            $table->unsignedInteger('cost_credits');
            $table->enum('rarity', ['common', 'rare', 'epic', 'legendary']);
            $table->unsignedSmallInteger('stock')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
