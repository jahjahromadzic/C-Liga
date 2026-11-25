<?php

namespace App\Models;

use App\Enums\MatchResultType;
use App\Enums\MatchStage;
use App\Enums\MatchStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A single match (utakmica). Named GameMatch because "match" is a reserved word in PHP.
 */
#[Fillable([
    'tournament_id', 'group_id', 'stage', 'round', 'match_no', 'scheduled_at',
    'home_team_id', 'away_team_id', 'home_score', 'away_score',
    'home_penalties', 'away_penalties', 'result_type', 'winner_team_id', 'status', 'notes',
])]
class GameMatch extends Model
{
    protected $table = 'matches';

    protected function casts(): array
    {
        return [
            'stage' => MatchStage::class,
            'result_type' => MatchResultType::class,
            'status' => MatchStatus::class,
            'round' => 'integer',
            'match_no' => 'integer',
            'scheduled_at' => 'datetime',
            'home_score' => 'integer',
            'away_score' => 'integer',
            'home_penalties' => 'integer',
            'away_penalties' => 'integer',
        ];
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(TournamentGroup::class, 'group_id');
    }

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'winner_team_id');
    }

    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class, 'match_id');
    }

    public function cards(): HasMany
    {
        return $this->hasMany(Card::class, 'match_id');
    }

    public function isBye(): bool
    {
        return $this->result_type === MatchResultType::Bye;
    }

    public function isForfeit(): bool
    {
        return $this->result_type === MatchResultType::Forfeit;
    }

    public function wentToPenalties(): bool
    {
        return $this->home_penalties !== null && $this->away_penalties !== null;
    }
}
