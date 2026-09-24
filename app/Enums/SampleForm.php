<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SampleForm: string implements HasLabel
{
    case Liquid = 'liquid';
    case Solid = 'solid';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Liquid => 'Produk Cair',
            self::Solid => 'Produk Padat',
        };
    }
}
