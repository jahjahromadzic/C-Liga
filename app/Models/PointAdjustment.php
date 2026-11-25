<?php

namespace App\Models;

use App\Enums\PointAdjustmentReason;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** League points added or removed outside normal tournament scoring. */
#[Fillable(['season_id', 'team_id', 'tournament_id', 'points', 'reason', 'note', 'created_by'])]
class PointAdjustment extends Model
{
    protected function casts(): array
    {
        return [
            'points' => 'integer',
            'reason' => PointAdjustmentReason::class,
        ];
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function tournament(): BelongsTo
    {
        return $this->belongsTo(Tournament::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
