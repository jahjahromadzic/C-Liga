<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'name', 'representative_name', 'representative_phone', 'place',
    'created_by', 'is_verified', 'notes',
])]
class Team extends Model
{
    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
        ];
    }

    /** All registrations of this team (one per tournament). */
    public function registrations(): HasMany
    {
        return $this->hasMany(TournamentTeam::class);
    }

    /** Tournaments this team registered for. */
    public function tournaments(): BelongsToMany
    {
        return $this->belongsToMany(Tournament::class, 'tournament_teams')
            ->using(TournamentTeam::class)
            ->withPivot(['id', 'status', 'placement', 'round_reached', 'points'])
            ->withTimestamps();
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function charges(): HasMany
    {
        return $this->hasMany(Charge::class);
    }

    public function pointAdjustments(): HasMany
    {
        return $this->hasMany(PointAdjustment::class);
    }

    public function suspensions(): HasMany
    {
        return $this->hasMany(Suspension::class);
    }
}
