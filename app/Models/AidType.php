<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AidType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'has_nominal',
        'unit',
        'is_active'
    ];

    protected $casts = [
        'has_nominal' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function sessionItems(): HasMany
    {
        return $this->hasMany(AidSessionItem::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}