<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SocialShare extends Model
{
    protected $fillable = [
        'shareable_type', 'shareable_id', 'platform', 'share_url', 'points_earned', 'verified', 'verified_at',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    public function shareable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeVerified($query)
    {
        return $query->where('verified', true);
    }

    public function scopeByPlatform($query, string $platform)
    {
        return $query->where('platform', $platform);
    }
}
