<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ClientType: string implements HasLabel
{
    case Institution = 'institution';
    case Public = 'public';
    case Business = 'business';
    case Internal = 'internal';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Institution => 'Instansi Pemerintah / Swasta',
            self::Public => 'Masyarakat',
            self::Business => 'Pelaku Usaha',
            self::Internal => 'Internal (Tim Sampling BBPOM)',
        };
    }
}
