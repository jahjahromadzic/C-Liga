<?php

namespace App\Models;

use App\Enums\TournamentFormat;
use App\Enums\TournamentStatus;
use App\Enums\TournamentType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'season_id', 'delegate_id', 'ordinal', 'type', 'format', 'name', 'location',
    'starts_on', 'ends_on', 'organizer_name', 'organizer_phone', 'prize_fund',
    'entry_fee', 'match_minutes', 'status', 'notes',
])]
class Tournament extends Model
{
    protected function casts(): array
    {
        return [
            'type' => TournamentType::class,
            'format' => TournamentFormat::class,
            'status' => TournamentStatus::class,
            'starts_on' => 'date',
            'ends_on' => 'date',
            'prize_fund' => 'decimal:2',
            'entry_fee' => 'decimal:2',
            'submitted_at' => 'datetime',
            'approved_at' => 'datetime',
        ];
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function delegate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'delegate_id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function groups(): HasMany
    {
        return $this->hasMany(TournamentGroup::class)->orderBy('name');
    }

    public function isFinals(): bool
    {
        return $this->type === TournamentType::Finals;
    }

    public function isApproved(): bool
    {
        return $this->status === TournamentStatus::Approved;
    }
}
