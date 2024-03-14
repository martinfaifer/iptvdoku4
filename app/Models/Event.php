<?php

namespace App\Models;

use App\Observers\EventObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(EventObserver::class)]
class Event extends Model
{
    protected $fillable = [
        'label', 'description', 'color', 'start_date', 'start_time',
        'end_date', 'end_time', 'creator', 'users'
    ];

    public function description(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::of($value)->markdown(),
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator', 'email');
    }
}
