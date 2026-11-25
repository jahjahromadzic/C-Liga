<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['tournament_id', 'name', 'advance_count'])]
class TournamentGroup extends Model
{
    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }
}
