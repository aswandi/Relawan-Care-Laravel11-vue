<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VolunteerActivity extends Model
{
    protected $fillable = [
        'volunteer_id',
        'beneficiary_id', 
        'aid_session_id',
        'visit_date',
        'latitude',
        'longitude',
        'notes',
        'status'
    ];

    protected $casts = [
        'visit_date' => 'date',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8'
    ];

    // Add accessor for activity_date to maintain compatibility
    public function getActivityDateAttribute()
    {
        return $this->visit_date;
    }

    public function volunteer(): BelongsTo
    {
        return $this->belongsTo(Volunteer::class);
    }

    public function beneficiary(): BelongsTo
    {
        return $this->belongsTo(Beneficiary::class);
    }

    public function aidSession(): BelongsTo
    {
        return $this->belongsTo(AidSession::class);
    }

    public function aids(): HasMany
    {
        return $this->hasMany(ActivityAid::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ActivityPhoto::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(static::class);
    }
}
