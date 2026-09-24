<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistrationDocument extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'registration_id',
        'type',
        'path',
        'file_name',
        'mime',
        'size_kb',
    ];

    protected function casts(): array
    {
        return [
            'size_kb' => 'integer',
        ];
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }
}
