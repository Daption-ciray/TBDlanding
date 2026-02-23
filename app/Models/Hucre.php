<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Hucre extends Model
{
    protected $table = 'hucreler';

    protected $fillable = [
        'name', 'role', 'xp', 'credits', 'level', 'slug', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Hucre $hucre) {
            if (empty($hucre->slug)) {
                $hucre->slug = Str::slug($hucre->name);
            }
        });
    }

    public function teams(): HasMany
    {
        return $this->hasMany(Team::class, 'hucre_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    public function addXp(int $amount): void
    {
        $this->increment('xp', $amount);
        $this->checkLevelUp();
    }

    public function spendCredits(int $amount): bool
    {
        if ($this->credits < $amount) {
            return false;
        }
        $this->decrement('credits', $amount);
        return true;
    }

    public function checkLevelUp(): void
    {
        $thresholds = config('livingcode.gamification.level_thresholds', []);
        $newLevel = 1;
        foreach ($thresholds as $level => $threshold) {
            if ($this->xp >= $threshold) {
                $newLevel = $level;
            }
        }
        if ($newLevel > $this->level) {
            $oldLevel = $this->level;
            $this->update(['level' => $newLevel]);
            LevelAnnouncement::create([
                'message' => "{$this->name} seviye {$newLevel}'e yükseldi!",
                'type' => 'level_up',
                'meta' => ['old_level' => $oldLevel, 'new_level' => $newLevel, 'hucre_id' => $this->id],
            ]);
        }
    }

    public function getTotalSupportersAttribute(): int
    {
        return $this->teams()->sum('supporter_count');
    }

    public function getTotalBadgesAttribute(): int
    {
        return $this->teams()->withCount('badges')->get()->sum('badges_count');
    }
}
