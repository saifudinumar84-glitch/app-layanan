<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum RegistrationFeeCategory: string implements HasColor, HasLabel
{
    case PaidService = 'paid_service';
    case FreePoisoning = 'free_poisoning';
    case FreeMsme = 'free_msme';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PaidService => 'Layanan Berbayar (PNBP)',
            self::FreePoisoning => 'Gratis (Sampel Keracunan / KLB)',
            self::FreeMsme => 'Gratis (Fasilitasi UMKM)',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PaidService => 'primary',
            self::FreePoisoning => 'danger',
            self::FreeMsme => 'success',
        };
    }
}
