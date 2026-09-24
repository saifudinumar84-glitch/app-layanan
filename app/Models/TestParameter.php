<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TestParameter extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'code',
        'name',
        'result_unit',
        'tariff',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'tariff' => 'decimal:2',
            'is_active' => 'boolean',
        ];
    }

    public function foodTypes(): BelongsToMany
    {
        return $this->belongsToMany(FoodType::class, 'food_type_parameters')
            ->withTimestamps();
    }

    public function sampleParameters(): HasMany
    {
        return $this->hasMany(SampleParameter::class);
    }
}
