<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Badge extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'icon', 'type', 'rarity', 'criteria', 'is_tradeable',
    ];

    protected $casts = [
        'criteria' => 'array',
        'is_tradeable' => 'boolean',
    ];

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class, 'team_badges')->withPivot('earned_at');
    }

    public function viewers(): BelongsToMany
    {
        return $this->belongsToMany(Viewer::class, 'viewer_badges')->withPivot('earned_at');
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByRarity($query, string $rarity)
    {
        return $query->where('rarity', $rarity);
    }

    public function scopeTradeable($query)
    {
        return $query->where('is_tradeable', true);
    }

    public function getRarityColorAttribute(): string
    {
        return match ($this->rarity) {
            'common' => 'gray',
            'rare' => 'blue',
            'epic' => 'purple',
            'legendary' => 'gold',
            default => 'gray',
        };
    }
}
