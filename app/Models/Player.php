<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['first_name', 'last_name', 'birth_year', 'place', 'created_by', 'is_verified'])]
class Player extends Model
{
    protected function casts(): array
    {
        return [
            'birth_year' => 'integer',
            'is_verified' => 'boolean',
        ];
    }

    /** $player->full_name → "Mujo Mujić" */
    protected function fullName(): Attribute
    {
        return Attribute::get(fn (): string => "{$this->first_name} {$this->last_name}");
    }

    /** Every roster entry of this player (one per tournament). */
    public function rosterEntries(): HasMany
    {
        return $this->hasMany(TournamentPlayer::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
