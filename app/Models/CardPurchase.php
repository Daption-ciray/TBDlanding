<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardPurchase extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'team_id', 'card_id', 'target_team_id', 'credits_spent', 'purchased_at', 'used_at', 'result_data',
    ];

    protected $casts = [
        'purchased_at' => 'datetime',
        'used_at' => 'datetime',
        'result_data' => 'array',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function card(): BelongsTo
    {
        return $this->belongsTo(Card::class);
    }

    public function targetTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'target_team_id');
    }

    public function isUsed(): bool
    {
        return $this->used_at !== null;
    }
}
