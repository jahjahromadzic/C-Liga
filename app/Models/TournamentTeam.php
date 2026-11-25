<?php

namespace App\Models;

use App\Enums\RegistrationStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * A team's registration for one tournament (prijava ekipe).
 * Extends Pivot so it can also be used as the pivot of Team ↔ Tournament.
 */
#[Fillable([
    'tournament_id', 'team_id', 'group_id', 'seed', 'has_reentry', 'status',
    'placement', 'round_reached', 'points', 'registered_by',
])]
class TournamentTeam extends Pivot
{
    protected $table = 'tournament_teams';

    public $incrementing = true;

    protected function casts(): array
    {
        return [
            'status' => RegistrationStatus::class,
            'has_reentry' => 'boolean',
            'seed' => 'integer',
            'placement' => 'integer',
            'round_reached' => 'integer',
            'points' => 'integer',
        ];
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(TournamentGroup::class, 'group_id');
    }

    /** Roster: players registered for this team at this tournament. */
    public function players(): HasMany
    {
        return $this->hasMany(TournamentPlayer::class, 'tournament_team_id');
    }

    public function registeredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registered_by');
    }
}
