<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum MarketingAuthorization: string implements HasColor, HasLabel
{
    case PIRT = 'PIRT';
    case MD = 'MD';
    case ML = 'ML';
    case TIE = 'TIE';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PIRT => 'P-IRT (Produk Industri Rumah Tangga)',
            self::MD => 'BPOM RI MD (Makanan Dalam Negeri)',
            self::ML => 'BPOM RI ML (Makanan Luar Negeri / Impor)',
            self::TIE => 'TIE (Tanpa Izin Edar)',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::PIRT => 'info',
            self::MD => 'success',
            self::ML => 'primary',
            self::TIE => 'danger',
        };
    }
}
