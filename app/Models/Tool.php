<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tool extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function tool_request(): HasMany
    {
        return $this->hasMany(RequestTool::class, 'tool_id');
    }

    public function latest_request(): HasOne
    {
        return $this->hasOne(RequestTool::class, 'tool_id')->latestOfMany();
    }
}
