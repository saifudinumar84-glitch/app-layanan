<?php

namespace App\Models;

use App\Enums\SampleConclusion;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SampleParameter extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'sample_id',
        'test_parameter_id',
        'result_value',
        'unit',
        'requirement_limit',
        'compliance_status',
        'analyzed_by',
        'tested_at',
    ];

    protected function casts(): array
    {
        return [
            'compliance_status' => SampleConclusion::class,
            'tested_at' => 'datetime',
        ];
    }

    public function sample(): BelongsTo
    {
        return $this->belongsTo(Sample::class);
    }

    public function testParameter(): BelongsTo
    {
        return $this->belongsTo(TestParameter::class);
    }

    public function analyzedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'analyzed_by');
    }

    public function invoiceItem(): HasOne
    {
        return $this->hasOne(InvoiceItem::class);
    }
}
