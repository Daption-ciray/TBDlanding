<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE cards ADD CONSTRAINT cards_stock_non_negative CHECK (stock >= 0)');
        DB::statement('ALTER TABLE quests ADD CONSTRAINT quests_completions_limit CHECK (current_completions <= max_completions OR max_completions = 0)');
        DB::statement('ALTER TABLE badge_trades ADD CONSTRAINT badge_trades_no_self_trade CHECK (from_team_id != to_team_id)');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE cards DROP CONSTRAINT IF EXISTS cards_stock_non_negative');
        DB::statement('ALTER TABLE quests DROP CONSTRAINT IF EXISTS quests_completions_limit');
        DB::statement('ALTER TABLE badge_trades DROP CONSTRAINT IF EXISTS badge_trades_no_self_trade');
    }
};
