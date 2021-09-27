<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequestConsumable extends Model
{
    use HasFactory;

    protected $fillable = ['service_order', 'user_id', 'consumable_id', 'requested_quantity', 'accepted_quantity', 'request_status', 'requested_at', 'accepted_at', 'rejected_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function consumable(): BelongsTo
    {
        return $this->belongsTo(Consumable::class, 'consumable_id');
    }
}
