<?php

namespace App\Models;

use App\Observers\IpObserver;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(IpObserver::class)]
class Ip extends Model
{
    protected $fillable = [
        'ip_address',
        'mask',
        'cidr',
        'ip_cidr_hash',
        'nangu_isp_id',
    ];

    public function nangu_isp(): BelongsTo
    {
        return $this->belongsTo(NanguIsp::class, 'nangu_isp_id');
    }

    public function scopeSearch(Builder $query, string $search): void
    {
        $query->where('ip_address', 'like', '%' . $search . '%');
    }
}
