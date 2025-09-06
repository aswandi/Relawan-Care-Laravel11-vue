<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdministrativeRegion extends Model
{
    protected $fillable = [
        'parent_id',
        'pro_id',
        'dapil_id', 
        'kab_id',
        'kec_id',
        'kel_id',
        'tps_id',
        'pro_kode',
        'dapil_kode',
        'kab_kode', 
        'kec_kode',
        'kel_kode',
        'tps_kode',
        'pro_nama',
        'dapil_nama',
        'kab_nama',
        'kec_nama', 
        'kel_nama',
        'tps_nama',
        'tingkat',
        'url',
        'code',
        'name'
    ];

    protected $casts = [
        'pro_id' => 'integer',
        'dapil_id' => 'integer',
        'kab_id' => 'integer', 
        'kec_id' => 'integer',
        'kel_id' => 'integer',
        'tps_id' => 'integer',
        'tingkat' => 'integer'
    ];

    // Hierarchical relationships using parent_id
    public function parent(): BelongsTo
    {
        return $this->belongsTo(AdministrativeRegion::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(AdministrativeRegion::class, 'parent_id');
    }

    // Legacy attributes for backward compatibility
    public function getParentAttribute()
    {
        return $this->parent;
    }

    public function getChildrenAttribute()
    {
        return $this->children;
    }

    // Volunteers relationship
    public function volunteersKabupaten(): HasMany
    {
        return $this->hasMany(Volunteer::class, 'kabupaten_id');
    }

    public function volunteersKecamatan(): HasMany
    {
        return $this->hasMany(Volunteer::class, 'kecamatan_id');
    }

    public function volunteersDesa(): HasMany
    {
        return $this->hasMany(Volunteer::class, 'desa_id');
    }

    // Beneficiaries relationship
    public function beneficiariesKabupaten(): HasMany
    {
        return $this->hasMany(Beneficiary::class, 'kabupaten_id');
    }

    public function beneficiariesKecamatan(): HasMany
    {
        return $this->hasMany(Beneficiary::class, 'kecamatan_id');
    }

    public function beneficiariesDesa(): HasMany
    {
        return $this->hasMany(Beneficiary::class, 'desa_id');
    }

    // Scopes based on tingkat
    public function scopeKabupaten($query)
    {
        return $query->where('tingkat', 2);
    }

    public function scopeKecamatan($query)
    {
        return $query->where('tingkat', 3);
    }

    public function scopeDesa($query)
    {
        return $query->where('tingkat', 4);
    }

    public function scopeKelurahan($query)
    {
        return $query->where('tingkat', 4);
    }

    // Helper methods
    public function getLevelAttribute()
    {
        switch ($this->tingkat) {
            case 2:
                return 'kabupaten';
            case 3:
                return 'kecamatan';  
            case 4:
                return 'desa';
            default:
                return 'unknown';
        }
    }

    public function getDisplayNameAttribute()
    {
        switch ($this->tingkat) {
            case 2:
                return $this->kab_nama ?: $this->name;
            case 3:
                return $this->kec_nama ?: $this->name;
            case 4:
                return $this->kel_nama ?: $this->name;
            default:
                return $this->name;
        }
    }
}
