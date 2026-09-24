<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum UserRole: string implements HasColor, HasLabel
{
    case Admin = 'admin';
    case ReceivingOfficer = 'receiving_officer';
    case Analyst = 'analyst';
    case Executive = 'executive';
    case Client = 'client';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::ReceivingOfficer => 'Petugas Penerima Sampel',
            self::Analyst => 'Analis Laboratorium',
            self::Executive => 'Pimpinan (Kepala Balai)',
            self::Client => 'Klien',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Admin => 'danger',
            self::ReceivingOfficer => 'info',
            self::Analyst => 'warning',
            self::Executive => 'primary',
            self::Client => 'gray',
        };
    }
}
