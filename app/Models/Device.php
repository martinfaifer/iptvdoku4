<?php

namespace App\Models;

use App\Observers\DeviceObserver;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[ObservedBy(DeviceObserver::class)]
class Device extends Model
{
    protected $fillable = [
        'name',
        'device_category_id',
        'device_vendor_id',
        'ip',
        'controller_ip',
        'username',
        'password',
        'zbx_id',
        'zbx_status',
        'is_snmp',
        'snmp_version',
        'snmp_private_comunity',
        'snmp_public_comunity',
        'template',
        'showed_create_template',
        'has_channels',
        'ipmi_ip',
    ];

    protected $casts = [
        'has_channels' => 'array',
    ];

    public function ssh(): HasOne
    {
        return $this->hasOne(DeviceSsh::class, 'device_id', 'id');
    }

    protected function template(): Attribute
    {
        return Attribute::make(
            get: fn($value) => json_decode($value, true),
            set: fn($value) => json_encode($value)
        );
    }

    protected function has_channels(): Attribute
    {
        return Attribute::make(
            // get: fn ($value) => json_decode($value, true),
            set: fn($value) => (array) $value
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(DeviceCategory::class, 'device_category_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(DeviceVendor::class, 'device_vendor_id');
    }

    public function notes(): HasMany
    {
        return $this->hasMany(Note::class, 'device_id');
    }

    public function oids(): HasMany
    {
        return $this->hasMany(DeviceOid::class, 'device_id', 'id');
    }

    public function scopeSearch(Builder $query, string $search): void
    {
        $this->where('name', 'like', '%' . $search . '%')
            ->orWhere('ip', 'like', '%' . $search . '%');
    }

    public function scopeFulltextSearch(Builder $query, string $search): void
    {
        $query->whereFullText(
            ['name', 'ip', 'controller_ip', 'zbx_status', 'ipmi_ip'],
            "$search*",
            ['mode' => 'boolean'],
        );
    }

    public function scopeInTemplate(Builder $query, string $searcheableString): void
    {
        $query->where('template', 'like', '%' . $searcheableString . '%');
    }
}
