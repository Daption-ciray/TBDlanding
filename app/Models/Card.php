<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Card extends Model
{
    protected $fillable = [
        'name', 'slug', 'type', 'description', 'effect_description', 'effect_data',
        'cost_credits', 'rarity', 'stock', 'is_active',
    ];

    protected $casts = [
        'effect_data' => 'array',
        'is_active' => 'boolean',
    ];

    public function purchases(): HasMany
    {
        return $this->hasMany(CardPurchase::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeLutuf($query)
    {
        return $query->where('type', 'lutuf');
    }

    public function scopeGazap($query)
    {
        return $query->where('type', 'gazap');
    }

    public function isAvailable(): bool
    {
        return $this->is_active && $this->stock > 0;
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
