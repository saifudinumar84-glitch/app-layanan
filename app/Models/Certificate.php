<?php

namespace App\Models;

use App\Enums\SampleConclusion;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'certificate_number',
        'sample_id',
        'conclusion',
        'file_path',
        'issued_by',
        'issued_at',
    ];

    protected function casts(): array
    {
        return [
            'conclusion' => SampleConclusion::class,
            'issued_at' => 'datetime',
        ];
    }

    public function sample(): BelongsTo
    {
        return $this->belongsTo(Sample::class);
    }

    public function issuedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
}
