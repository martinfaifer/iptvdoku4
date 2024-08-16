<?php

namespace App\Models;

use App\Observers\SatelitCardObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy(SatelitCardObserver::class)]
class SatelitCard extends Model
{
    protected $fillable = [
        'name',
        'satelit_card_vendor_id',
        'status',
        'expiration',
    ];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(SatelitCardVendor::class, 'satelit_card_vendor_id');
    }

    public function contents(): HasMany
    {
        return $this->hasMany(SatelitCardContent::class, 'satelit_card_id');
    }

    public function scopeSearch(Builder $query, string $search = '')
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }
}
