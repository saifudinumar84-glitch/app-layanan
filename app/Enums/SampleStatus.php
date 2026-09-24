<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum SampleStatus: string implements HasColor, HasLabel
{
    case AwaitingSample = 'awaiting_sample';
    case Received = 'received';
    case InTesting = 'in_testing';
    case Completed = 'completed';
    case Rejected = 'rejected';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::AwaitingSample => 'Menunggu Penyerahan Sampel',
            self::Received => 'Sampel Diterima',
            self::InTesting => 'Dalam Pengujian (In Testing)',
            self::Completed => 'Pengujian Selesai',
            self::Rejected => 'Sampel Ditolak (Tidak Memenuhi Syarat)',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::AwaitingSample => 'gray',
            self::Received => 'info',
            self::InTesting => 'warning',
            self::Completed => 'success',
            self::Rejected => 'danger',
        };
    }

    public function isOnProcess(): bool
    {
        return in_array($this, [self::Received, self::InTesting]);
    }
}
