<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** Suspension decided by the Radna grupa (čl. 8.16). */
#[Fillable([
    'season_id', 'player_id', 'team_id', 'reason', 'matches', 'tournaments', 'until_date', 'created_by',
])]
class Suspension extends Model
{
    protected function casts(): array
    {
        return [
            'matches' => 'integer',
            'tournaments' => 'integer',
            'until_date' => 'date',
        ];
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
