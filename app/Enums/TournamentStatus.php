<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TournamentStatus: string implements HasLabel
{
    /** In the calendar, not started yet. */
    case Planned = 'planned';

    /** Delegate is entering data. */
    case InProgress = 'in_progress';

    /** Delegate finished and submitted it for review. */
    case Submitted = 'submitted';

    /** Admin approved it; it now counts in the league table. */
    case Approved = 'approved';

    public function getLabel(): string
    {
        return match ($this) {
            self::Planned => 'Planiran',
            self::InProgress => 'U toku',
            self::Submitted => 'Predan',
            self::Approved => 'Odobren',
        };
    }
}
