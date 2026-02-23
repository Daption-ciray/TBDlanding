<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class QuestCompletion extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'quest_id', 'completable_type', 'completable_id', 'proof_url', 'xp_earned', 'credits_earned', 'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function quest(): BelongsTo
    {
        return $this->belongsTo(Quest::class);
    }

    public function completable(): MorphTo
    {
        return $this->morphTo();
    }
}
