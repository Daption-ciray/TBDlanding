<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participant extends Model
{
    protected $fillable = [
        'team_id', 'name', 'email', 'role_in_team', 'xp', 'avatar',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function scopeTopByXp($query, int $limit = 10)
    {
        return $query->orderByDesc('xp')->limit($limit);
    }
}
