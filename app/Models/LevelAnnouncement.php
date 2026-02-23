<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LevelAnnouncement extends Model
{
    protected $fillable = [
        'team_id', 'viewer_id', 'message', 'type', 'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function viewer(): BelongsTo
    {
        return $this->belongsTo(Viewer::class);
    }

    public function scopeRecent($query, int $limit = 20)
    {
        return $query->orderByDesc('created_at')->limit($limit);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function getIconAttribute(): string
    {
        $subtype = is_array($this->meta) ? ($this->meta['subtype'] ?? null) : null;
        if ($subtype === 'team_rank_change') {
            return '🏆';
        }
        if ($subtype === 'viewer_rank_change') {
            return '👁️';
        }
        return match ($this->type) {
            'level_up' => '⬆️',
            'badge_earned' => '🏅',
            'quest_complete' => '✅',
            'card_used' => '🃏',
            'tester_called' => '🧪',
            'trade_complete' => '🤝',
            'social_share' => '📢',
            'system' => '⚙️',
            default => '📌',
        };
    }
}
