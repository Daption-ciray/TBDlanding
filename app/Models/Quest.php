<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quest extends Model
{
    protected $fillable = [
        'title', 'slug', 'description', 'type', 'xp_reward', 'credit_reward',
        'starts_at', 'expires_at', 'max_completions', 'current_completions',
        'icon', 'difficulty', 'is_active',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function completions(): HasMany
    {
        return $this->hasMany(QuestCompletion::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('expires_at', '>', now());
    }

    public function scopeExpiringSoon($query, int $minutes = 60)
    {
        return $query->active()
            ->where('expires_at', '<=', now()->addMinutes($minutes));
    }

    public function scopeForTeams($query)
    {
        return $query->whereIn('type', ['team', 'both']);
    }

    public function scopeForViewers($query)
    {
        return $query->whereIn('type', ['viewer', 'both']);
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function isFull(): bool
    {
        return $this->max_completions > 0 && $this->current_completions >= $this->max_completions;
    }

    public function isAvailable(): bool
    {
        return $this->is_active && !$this->isExpired() && !$this->isFull();
    }

    public function getRemainingTimeAttribute(): string
    {
        if ($this->isExpired()) return 'Süresi doldu';
        return $this->expires_at->diffForHumans(now(), true);
    }

    public function getDifficultyColorAttribute(): string
    {
        return match ($this->difficulty) {
            'easy' => 'green',
            'medium' => 'gold',
            'hard' => 'red',
            default => 'gray',
        };
    }
}
