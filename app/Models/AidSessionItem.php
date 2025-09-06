<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AidSessionItem extends Model
{
    protected $fillable = [
        'aid_session_id',
        'aid_type_id',
        'quantity_available',
        'nominal_amount'
    ];

    protected $casts = [
        'quantity_available' => 'integer',
        'nominal_amount' => 'decimal:2'
    ];

    public function aidSession(): BelongsTo
    {
        return $this->belongsTo(AidSession::class);
    }

    public function aidType(): BelongsTo
    {
        return $this->belongsTo(AidType::class);
    }
}