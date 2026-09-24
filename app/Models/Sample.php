<?php

namespace App\Models;

use App\Enums\MarketingAuthorization;
use App\Enums\RiskCategory;
use App\Enums\SampleConclusion;
use App\Enums\SampleForm;
use App\Enums\SampleStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Sample extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'sample_number',
        'registration_id',
        'food_type_id',
        'sample_name',
        'brand',
        'sample_form',
        'unit_count',
        'unit_size',
        'marketing_authorization',
        'authorization_number',
        'risk_category',
        'purchase_price',
        'extra_info',
        'status',
        'conclusion',
        'received_by',
        'received_at',
        'search_vector',
    ];

    protected function casts(): array
    {
        return [
            'sample_form' => SampleForm::class,
            'marketing_authorization' => MarketingAuthorization::class,
            'risk_category' => RiskCategory::class,
            'purchase_price' => 'decimal:2',
            'extra_info' => 'array',
            'status' => SampleStatus::class,
            'conclusion' => SampleConclusion::class,
            'received_at' => 'datetime',
            'unit_count' => 'integer',
            'unit_size' => 'integer',
        ];
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function foodType(): BelongsTo
    {
        return $this->belongsTo(FoodType::class);
    }

    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function sampleParameters(): HasMany
    {
        return $this->hasMany(SampleParameter::class);
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class);
    }

    public function informationRequests(): HasMany
    {
        return $this->hasMany(InformationRequest::class);
    }

    public function statusHistories(): MorphMany
    {
        return $this->morphMany(StatusHistory::class, 'statusable');
    }
}
