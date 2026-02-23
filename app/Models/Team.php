<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Team extends Model
{
    protected $fillable = [
        'name', 'role', 'hucre_id', 'supporter_count', 'logo', 'slug', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Team $team) {
            if (empty($team->slug)) {
                $team->slug = Str::slug($team->name);
            }
        });
    }

    public function hucre(): BelongsTo
    {
        return $this->belongsTo(Hucre::class, 'hucre_id');
    }

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class, 'team_badges')->withPivot('earned_at');
    }

    public function cardPurchases(): HasMany
    {
        return $this->hasMany(CardPurchase::class);
    }

    public function receivedCards(): HasMany
    {
        return $this->hasMany(CardPurchase::class, 'target_team_id');
    }

    public function questCompletions()
    {
        return $this->morphMany(QuestCompletion::class, 'completable');
    }

    public function outgoingTrades(): HasMany
    {
        return $this->hasMany(BadgeTrade::class, 'from_team_id');
    }

    public function incomingTrades(): HasMany
    {
        return $this->hasMany(BadgeTrade::class, 'to_team_id');
    }

    public function mentorRequests(): HasMany
    {
        return $this->hasMany(MentorRequest::class);
    }

    public function testerRequests(): HasMany
    {
        return $this->hasMany(TesterRequest::class);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(LevelAnnouncement::class);
    }

    public function socialShares()
    {
        return $this->morphMany(SocialShare::class, 'shareable');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeTopByXp($query, int $limit = 10)
    {
        return $query->active()->orderByDesc('xp')->limit($limit);
    }

    public function scopeByRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    public function addXp(int $amount): void
    {
        if ($this->hucre) {
            $this->hucre->addXp($amount);
        }
    }

    public function spendCredits(int $amount): bool
    {
        if ($this->hucre) {
            return $this->hucre->spendCredits($amount);
        }
        return false;
    }

    public function getCreditsAttribute(): int
    {
        return $this->hucre ? $this->hucre->credits : 0;
    }

    public function getXpAttribute(): int
    {
        return $this->hucre ? $this->hucre->xp : 0;
    }

    public function getLevelAttribute(): int
    {
        return $this->hucre ? $this->hucre->level : 1;
    }

    public function getBadgeCountAttribute(): int
    {
        return $this->badges()->count();
    }
}
