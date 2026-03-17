<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Eski basit tabloyu silelim veya dönüştürelim
        Schema::dropIfExists('role_clicks');

        Schema::create('role_interactions', function (Blueprint $table) {
            $table->id();
            $table->string('role_key'); // 'kasif' or 'mimar'
            $table->string('ip_address');
            $table->enum('type', ['click', 'registration'])->default('click');
            $table->timestamps();

            // Aynı IP bir role sadece bir kez tıklayabilsin (veya kayıt olabilsin)
            $table->unique(['role_key', 'ip_address', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('role_interactions');
    }
};
