<?php

namespace App\Models;

use App\Enums\RegistrationSamplingType;
use App\Enums\SampleForm;
use App\Enums\SampleUnit;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SampleRequirement extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'food_type_id',
        'sample_form',
        'min_units',
        'unit_size',
        'unit',
        'sampling_type',
        'special_requirements',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'sample_form' => SampleForm::class,
            'unit' => SampleUnit::class,
            'sampling_type' => RegistrationSamplingType::class,
            'special_requirements' => 'array',
            'is_active' => 'boolean',
            'min_units' => 'integer',
            'unit_size' => 'integer',
        ];
    }

    public function foodType(): BelongsTo
    {
        return $this->belongsTo(FoodType::class);
    }
}
