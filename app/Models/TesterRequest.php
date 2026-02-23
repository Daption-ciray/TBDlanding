<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TesterRequest extends Model
{
    protected $fillable = [
        'team_id', 'xp_cost', 'status', 'feedback', 'rating', 'tested_at',
    ];

    protected $casts = [
        'tested_at' => 'datetime',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['pending', 'testing']);
    }
}
