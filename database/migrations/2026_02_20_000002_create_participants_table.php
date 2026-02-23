<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('email')->unique();
            $table->enum('role_in_team', ['adem', 'baba', 'hybrid']);
            $table->unsignedInteger('xp')->default(0);
            $table->string('avatar')->nullable();
            $table->timestamps();

            $table->index('xp');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};
