<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Observers\UserObserver;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Cache;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Foundation\Auth\User as Authenticatable;

#[ObservedBy(UserObserver::class)]
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'user_role_id',
        'avatar_url',
        'notify_if_channel_change',
        'notify_if_added_new_wiki_content',
        'notify_if_weather_problem',
        'notify_if_too_many_channels_down',
        'notify_if_satelit_card_has_expiration',
        'notify_if_added_new_event',
        'notify_if_upload_new_banner',
        'notify_if_channel_was_added_to_promo',
        'iptv_monitoring_window',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'notify_if_channel_change' => 'boolean',
        'notify_if_added_new_wiki_content' => 'boolean',
        'notify_if_weather_problem' => 'boolean',
        'notify_if_too_many_channels_down' => 'boolean',
        'notify_if_satelit_card_has_expiration' => 'boolean',
        'notify_if_added_new_event' => 'boolean',
        'notify_if_upload_new_banner' => 'boolean',
        'notify_if_channel_was_added_to_promo' => 'boolean',
    ];

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn($value) => bcrypt($value)
        );
    }

    public function userRole(): BelongsTo
    {
        return $this->belongsTo(UserRole::class, 'user_role_id', 'id');
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class, 'user_id', 'id');
    }

    public function isAdmin(): bool
    {
        if (!Cache::has('is_admin')) {
            Cache::forever('is_admin', UserRole::admin()->first()->id);
        }
        return $this->user_role_id == Cache::get('is_admin');
    }

    public function isTechnik(): bool
    {
        if (!Cache::has('is_technik')) {
            Cache::forever('is_technik', UserRole::technik()->first()->id);
        }
        return $this->user_role_id == Cache::get('is_technik');
    }

    public function isAdministrativa(): bool
    {
        if (!Cache::has('is_administrativa')) {
            Cache::forever('is_administrativa', UserRole::administrativa()->first()->id);
        }
        return $this->user_role_id == Cache::get('is_administrativa');
    }

    public function isApi(): bool
    {
        if (!Cache::has('is_api')) {
            Cache::forever('is_api', UserRole::api()->first()->id);
        }
        return $this->user_role_id == Cache::get('is_api');
    }

    public function isReader(): bool
    {
        if (!Cache::has('is_reader')) {
            Cache::forever('is_reader', UserRole::reader()->first()->id);
        }
        return $this->user_role_id == UserRole::reader()->first()->id;
    }

    public function scopeSearch(Builder $query, string $search): void
    {
        $query
            ->where('first_name', 'like', '%' . $search . '%')
            ->orWhere('last_name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%');
    }
}
