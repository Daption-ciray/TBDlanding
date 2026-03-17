<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('role_clicks', function (Blueprint $table) {
            $table->id();
            $table->string('role_key')->unique(); // 'kasif' or 'mimar'
            $table->unsignedInteger('click_count')->default(0);
            $table->timestamps();
        });

        // Başlangıç değerlerini ata
        \DB::table('role_clicks')->insert([
            ['role_key' => 'kasif', 'click_count' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['role_key' => 'mimar', 'click_count' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('role_clicks');
    }
};
