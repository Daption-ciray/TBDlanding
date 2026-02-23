<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Viewer extends Model
{
    protected $fillable = [
        'name', 'email', 'total_watch_minutes', 'xp', 'current_streak', 'last_seen_at', 'session_token',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
    ];

    public function badges(): BelongsToMany
    {
        return $this->belongsToMany(Badge::class, 'viewer_badges')->withPivot('earned_at');
    }

    public function questCompletions()
    {
        return $this->morphMany(QuestCompletion::class, 'completable');
    }

    public function socialShares()
    {
        return $this->morphMany(SocialShare::class, 'shareable');
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(LevelAnnouncement::class);
    }

    public function xpClaims(): HasMany
    {
        return $this->hasMany(ViewerXpClaim::class);
    }

    public function scopeTopByWatchTime($query, int $limit = 10)
    {
        return $query->orderByDesc('total_watch_minutes')->limit($limit);
    }

    public function scopeTopByXp($query, int $limit = 10)
    {
        return $query->orderByDesc('xp')->limit($limit);
    }

    public function addXp(int $amount): void
    {
        $this->increment('xp', $amount);
    }

    public function addWatchMinutes(int $minutes): void
    {
        $this->increment('total_watch_minutes', $minutes);
        $this->update(['last_seen_at' => now()]);
    }

    public static function generateToken(): string
    {
        return Str::random(64);
    }
}
