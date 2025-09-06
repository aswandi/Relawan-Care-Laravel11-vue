<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Beneficiary extends Model
{
    protected $fillable = [
        'family_card_number',
        'national_id',
        'name',
        'phone',
        'address',
        'rt',
        'rw',
        'kabupaten_id',
        'kecamatan_id',
        'desa_id',
        'beneficiary_group_id',
        'age',
        'gender',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'age' => 'integer'
    ];

    // Administrative regions relationships
    public function kabupaten(): BelongsTo
    {
        return $this->belongsTo(AdministrativeRegion::class, 'kabupaten_id');
    }

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(AdministrativeRegion::class, 'kecamatan_id');
    }

    public function desa(): BelongsTo
    {
        return $this->belongsTo(AdministrativeRegion::class, 'desa_id');
    }

    public function beneficiaryGroup(): BelongsTo
    {
        return $this->belongsTo(BeneficiaryGroup::class);
    }

    // Activities relationship
    public function activities(): HasMany
    {
        return $this->hasMany(VolunteerActivity::class);
    }

    // Scope for active beneficiaries
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}