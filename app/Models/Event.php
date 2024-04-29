<?php

namespace App\Models;

use App\Observers\EventObserver;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

#[ObservedBy(EventObserver::class)]
class Event extends Model
{
    const BANNER_NAMES = [
        'stb_1113_grape.png', 'stb_1113_grape_ostatni.png',
    ];

    protected $fillable = [
        'label', 'description', 'color', 'start_date', 'start_time',
        'end_date', 'end_time', 'creator', 'users', 'channels', 'tag_id',
        'fe_notification', 'banner_path', 'sftp_server_id',
    ];

    // public function description(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn ($value) => Str::of($value)->markdown(),
    //     );
    // }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator', 'email');
    }

    public function background_color(): HasOne
    {
        return $this->hasOne(CssColor::class, 'id', 'color');
    }

    public function tag(): HasOne
    {
        return $this->hasOne(Tag::class, 'id', 'tag_id');
    }

    public function sftp_server(): HasOne
    {
        return $this->hasOne(SftpServer::class, 'id', 'sftp_server_id');
    }

    public function scopeRunningEvents(Builder $query)
    {
        return $query->where('start_date', '<=', now()->format('Y-m-d'))
            ->where('end_date', '>=', now()->format('Y-m-d'));
    }

    public function scopeHasFeNotification(Builder $query)
    {
        return $query->where('fe_notification', true);
    }
}
