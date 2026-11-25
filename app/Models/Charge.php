<?php

namespace App\Models;

use App\Enums\ChargeStatus;
use App\Enums\ChargeType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** A fee or fine (zaduženje). */
#[Fillable([
    'season_id', 'team_id', 'player_id', 'user_id', 'tournament_id', 'match_id',
    'type', 'amount', 'description', 'status', 'paid_at', 'receipt_no', 'recorded_by',
])]
class Charge extends Model
{
    protected function casts(): array
    {
        return [
            'type' => ChargeType::class,
            'status' => ChargeStatus::class,
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    /** Charge::unpaid()->get() */
    public function scopeUnpaid(Builder $query): void
    {
        $query->where('status', ChargeStatus::Unpaid);
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    /** Referee or delegate who owes an official fee. */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    public function match(): BelongsTo
    {
        return $this->belongsTo(GameMatch::class, 'match_id');
    }

    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
