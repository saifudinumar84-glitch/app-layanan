<?php

namespace App\Models;

use App\Enums\RiskCategory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FoodType extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'food_category_id',
        'name',
        'default_risk_category',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'default_risk_category' => RiskCategory::class,
            'is_active' => 'boolean',
        ];
    }

    public function foodCategory(): BelongsTo
    {
        return $this->belongsTo(FoodCategory::class);
    }

    public function testParameters(): BelongsToMany
    {
        return $this->belongsToMany(TestParameter::class, 'food_type_parameters')
            ->withTimestamps();
    }

    public function sampleRequirements(): HasMany
    {
        return $this->hasMany(SampleRequirement::class);
    }

    public function samples(): HasMany
    {
        return $this->hasMany(Sample::class);
    }
}
