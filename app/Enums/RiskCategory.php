<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum RiskCategory: string implements HasColor, HasLabel
{
    case Low = 'low';
    case Medium = 'medium';
    case High = 'high';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Low => 'Rendah (Low Risk)',
            self::Medium => 'Sedang (Medium Risk)',
            self::High => 'Tinggi (High Risk)',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Low => 'success',
            self::Medium => 'warning',
            self::High => 'danger',
        };
    }
}
