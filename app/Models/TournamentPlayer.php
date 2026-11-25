<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * One player on a team's roster at one tournament (spisak igrača).
 * tournament_id is copied from the registration automatically.
 */
#[Fillable(['tournament_team_id', 'player_id', 'shirt_number', 'is_paid_extra'])]
class TournamentPlayer extends Model
{
    protected function casts(): array
    {
        return [
            'shirt_number' => 'integer',
            'is_paid_extra' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        // Keep tournament_id in sync with the registration it belongs to.
        static::saving(function (TournamentPlayer $entry): void {
            $entry->tournament_id = TournamentTeam::query()
                ->whereKey($entry->tournament_team_id)
                ->value('tournament_id');
        });
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(TournamentTeam::class, 'tournament_team_id');
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }
}
