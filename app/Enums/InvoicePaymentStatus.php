<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum InvoicePaymentStatus: string implements HasColor, HasLabel
{
    case Unpaid = 'unpaid';
    case Paid = 'paid';
    case Free = 'free';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Unpaid => 'Belum Lunas (Unpaid)',
            self::Paid => 'Lunas (Paid)',
            self::Free => 'Gratis / Bebas Biaya (Free)',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Unpaid => 'danger',
            self::Paid => 'success',
            self::Free => 'info',
        };
    }
}
