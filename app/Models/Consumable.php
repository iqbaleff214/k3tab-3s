<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Consumable extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function consumable_request(): HasMany
    {
        return $this->hasMany(Consumable::class, 'consumable_id');
    }

    public function latest_request(): HasOne
    {
        return $this->hasOne(Consumable::class, 'consumable_id')->latestOfMany();
    }
}
