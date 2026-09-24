<?php

namespace App\Models;

use App\Enums\RegistrationFeeCategory;
use App\Enums\RegistrationSamplingType;
use App\Enums\RegistrationStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Registration extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'registration_number',
        'client_id',
        'sampling_type',
        'fee_category',
        'status',
        'form_data',
        'confirmed_by',
        'confirmed_at',
        'officer_notes',
        'registration_date',
    ];

    protected function casts(): array
    {
        return [
            'sampling_type' => RegistrationSamplingType::class,
            'fee_category' => RegistrationFeeCategory::class,
            'status' => RegistrationStatus::class,
            'form_data' => 'array',
            'confirmed_at' => 'datetime',
            'registration_date' => 'date',
        ];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(RegistrationDocument::class);
    }

    public function samples(): HasMany
    {
        return $this->hasMany(Sample::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function statusHistories(): MorphMany
    {
        return $this->morphMany(StatusHistory::class, 'statusable');
    }
}
