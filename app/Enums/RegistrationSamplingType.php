<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum RegistrationSamplingType: string implements HasColor, HasLabel
{
    case Targeted = 'targeted';
    case Assistance = 'assistance';
    case Case = 'case';
    case Poisoning = 'poisoning';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Targeted => 'Targeted (Rutin)',
            self::Assistance => 'Pendampingan',
            self::Case => 'Kasus / Investigasi Khusus',
            self::Poisoning => 'KLB / Keracunan Pangan',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Targeted => 'info',
            self::Assistance => 'success',
            self::Case => 'warning',
            self::Poisoning => 'danger',
        };
    }
}
