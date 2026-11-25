<?php

namespace App\Models;

use App\Enums\SeasonStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['year', 'name', 'status', 'rules'])]
class Season extends Model
{
    /**
     * Default rules, taken from "Propozicije C-Lige 2026".
     * A season stores only what differs; everything else falls back to these.
     */
    public const DEFAULT_RULES = [
        'participation_points' => 1,          // čl. 17.6
        'first_advance_points' => 2,          // čl. 2.6 (then doubles each round)
        'third_place_bonus_ratio' => 0.5,     // čl. 3.6
        'full_attendance_bonus' => 20,        // čl. 9.6
        'finals_min_attendance_pct' => 33,    // čl. 7.6
        'finals_team_count' => 6,             // čl. 2.7
        'max_players_per_tournament' => 13,   // čl. 10.11
        'free_players_limit' => 10,           // čl. 10.11
        'extra_player_fee' => 50,             // čl. 10.11 (KM)
        'team_membership_fee' => 10,          // čl. 2.3 (KM)
        'red_card_fine' => 30,                // čl. 5.3 (KM)
        'no_show_fine' => 50,                 // čl. 20.6 (KM)
        'no_show_points' => -1,               // čl. 20.6
        'name_change_fee' => 30,              // čl. 2.4 (KM)
        'finals_max_players' => 12,           // čl. 2.9
        'finals_new_players' => 3,            // čl. 3.9
        'finals_new_player_fee' => 100,       // čl. 3.9 (KM)
        'finals_no_show_fine' => 500,         // čl. 7.9 (KM)
        'finals_no_show_points' => -20,       // čl. 7.9 (next season)
        'yellow_cards_for_suspension' => 3,   // čl. 11.16 (per tournament)
    ];

    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'status' => SeasonStatus::class,
            'rules' => 'array',
        ];
    }

    public function tournaments(): HasMany
    {
        return $this->hasMany(Tournament::class)->orderBy('ordinal');
    }

    /** Read one rule for this season, e.g. $season->rule('red_card_fine'). */
    public function rule(string $key): mixed
    {
        return ($this->rules ?? [])[$key] ?? self::DEFAULT_RULES[$key] ?? null;
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
