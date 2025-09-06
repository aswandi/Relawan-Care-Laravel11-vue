<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class Volunteer extends Authenticatable
{
    use HasApiTokens;
    protected $fillable = [
        'volunteer_code',
        'name',
        'phone',
        'password',
        'kabupaten_id',
        'kecamatan_id',
        'desa_id',
        'address',
        'is_active'
    ];

    // Remove password from hidden to make it readable

    protected $casts = [
        'is_active' => 'boolean'
    ];

    // Store password as plain text 5-digit number
    public function setPasswordAttribute($value)
    {
        // Ensure it's a 5-digit number
        if (is_numeric($value) && strlen($value) == 5) {
            $this->attributes['password'] = $value;
        } else {
            // Generate random 5-digit number if invalid
            $this->attributes['password'] = str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);
        }
    }

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

    // Activities relationship
    public function activities(): HasMany
    {
        return $this->hasMany(VolunteerActivity::class);
    }

    // Scope for active volunteers
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
