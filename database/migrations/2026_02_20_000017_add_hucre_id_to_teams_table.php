<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->foreignId('hucre_id')->nullable()->after('role')->constrained('hucreler')->onDelete('set null');
            $table->index('hucre_id');
        });
    }

    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropForeign(['hucre_id']);
            $table->dropIndex(['hucre_id']);
            $table->dropColumn('hucre_id');
        });
    }
};
