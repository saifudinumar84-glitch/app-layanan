<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SampleUnit: string implements HasLabel
{
    case Ml = 'ml';
    case G = 'g';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Ml => 'ml',
            self::G => 'gram',
        };
    }
}
