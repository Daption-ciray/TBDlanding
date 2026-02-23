<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // FK indexes on participants
        if (!$this->hasIndex('participants', 'participants_team_id_index')) {
            Schema::table('participants', function (Blueprint $table) {
                $table->index('team_id');
            });
        }

        // FK indexes on card_purchases
        if (!$this->hasIndex('card_purchases', 'card_purchases_card_id_index')) {
            Schema::table('card_purchases', function (Blueprint $table) {
                $table->index('card_id');
                $table->index('purchased_at');
            });
        }

        // FK indexes on level_announcements
        if (!$this->hasIndex('level_announcements', 'level_announcements_team_id_index')) {
            Schema::table('level_announcements', function (Blueprint $table) {
                $table->index('team_id');
                $table->index('viewer_id');
            });
        }

        // FK indexes on badge_trades
        if (!$this->hasIndex('badge_trades', 'badge_trades_from_team_id_index')) {
            Schema::table('badge_trades', function (Blueprint $table) {
                $table->index('from_team_id');
                $table->index('to_team_id');
                $table->index('badge_id');
                $table->index('created_at');
            });
        }

        // FK indexes on mentor_requests
        if (!$this->hasIndex('mentor_requests', 'mentor_requests_team_id_index')) {
            Schema::table('mentor_requests', function (Blueprint $table) {
                $table->index('team_id');
            });
        }

        // FK indexes on tester_requests
        if (!$this->hasIndex('tester_requests', 'tester_requests_team_id_index')) {
            Schema::table('tester_requests', function (Blueprint $table) {
                $table->index('team_id');
            });
        }

        // Polymorphic composite indexes
        if (!$this->hasIndex('quest_completions', 'quest_completions_completable_index')) {
            Schema::table('quest_completions', function (Blueprint $table) {
                $table->index(['completable_type', 'completable_id'], 'quest_completions_completable_index');
            });
        }

        if (!$this->hasIndex('social_shares', 'social_shares_shareable_index')) {
            Schema::table('social_shares', function (Blueprint $table) {
                $table->index(['shareable_type', 'shareable_id'], 'social_shares_shareable_index');
                $table->index('verified');
            });
        }

        // Viewer last_seen_at for active queries
        if (!$this->hasIndex('viewers', 'viewers_last_seen_at_index')) {
            Schema::table('viewers', function (Blueprint $table) {
                $table->index('last_seen_at');
            });
        }

        // Composite index for quests active filter
        Schema::table('quests', function (Blueprint $table) {
            $table->index(['is_active', 'expires_at', 'type'], 'quests_active_expiry_type_index');
        });

        // Composite for viewer claims
        if (!$this->hasIndex('viewer_xp_claims', 'viewer_xp_claims_viewer_status_index')) {
            Schema::table('viewer_xp_claims', function (Blueprint $table) {
                $table->index(['viewer_id', 'status'], 'viewer_xp_claims_viewer_status_index');
            });
        }
    }

    public function down(): void
    {
        Schema::table('participants', fn (Blueprint $t) => $t->dropIndex(['team_id']));
        Schema::table('card_purchases', fn (Blueprint $t) => $t->dropIndex(['card_id']));
        Schema::table('card_purchases', fn (Blueprint $t) => $t->dropIndex(['purchased_at']));
        Schema::table('level_announcements', fn (Blueprint $t) => $t->dropIndex(['team_id']));
        Schema::table('level_announcements', fn (Blueprint $t) => $t->dropIndex(['viewer_id']));
        Schema::table('badge_trades', fn (Blueprint $t) => $t->dropIndex(['from_team_id']));
        Schema::table('badge_trades', fn (Blueprint $t) => $t->dropIndex(['to_team_id']));
        Schema::table('badge_trades', fn (Blueprint $t) => $t->dropIndex(['badge_id']));
        Schema::table('badge_trades', fn (Blueprint $t) => $t->dropIndex(['created_at']));
        Schema::table('mentor_requests', fn (Blueprint $t) => $t->dropIndex(['team_id']));
        Schema::table('tester_requests', fn (Blueprint $t) => $t->dropIndex(['team_id']));
        Schema::table('quest_completions', fn (Blueprint $t) => $t->dropIndex('quest_completions_completable_index'));
        Schema::table('social_shares', fn (Blueprint $t) => $t->dropIndex('social_shares_shareable_index'));
        Schema::table('social_shares', fn (Blueprint $t) => $t->dropIndex(['verified']));
        Schema::table('viewers', fn (Blueprint $t) => $t->dropIndex(['last_seen_at']));
        Schema::table('quests', fn (Blueprint $t) => $t->dropIndex('quests_active_expiry_type_index'));
        Schema::table('viewer_xp_claims', fn (Blueprint $t) => $t->dropIndex('viewer_xp_claims_viewer_status_index'));
    }

    private function hasIndex(string $table, string $indexName): bool
    {
        try {
            $indexes = Schema::getIndexes($table);
            foreach ($indexes as $index) {
                if ($index['name'] === $indexName) {
                    return true;
                }
            }
        } catch (\Throwable) {
        }
        return false;
    }
};
