<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FoodCategory extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'code',
        'name',
    ];

    public function foodTypes(): HasMany
    {
        return $this->hasMany(FoodType::class);
    }
}
