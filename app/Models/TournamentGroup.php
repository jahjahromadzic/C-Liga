<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['tournament_id', 'name', 'advance_count'])]
class TournamentGroup extends Model
{
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    /** Team registrations placed in this group. */
    public function registrations(): HasMany
    {
        return $this->hasMany(TournamentTeam::class, 'group_id');
    }
}
