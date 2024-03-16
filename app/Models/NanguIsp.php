<?php

namespace App\Models;

use App\Observers\NanguIspObserver;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy(NanguIspObserver::class)]
class NanguIsp extends Model
{
    protected $fillable = [
        'name', 'nangu_isp_id', 'is_akcionar', 'ic', 'dic', 'hbo_key', 'crm_contract_id'
    ];

    public function tags_to_channels_packages() :HasMany
    {
        return $this->hasMany(NanguIspTagToChannelPackage::class, 'nangu_isp_id', 'id');
    }

    public function scopeSearch(Builder $query, string $search)
    {
        return $query->where('name', "like", "%".$search."%")
                    ->orWhere('ic', 'like', "%".$search."%")
                    ->orWhere('dic', 'like', "%".$search."%")
                    ->orWhere('hbo_key', 'like', "%".$search."%")
                    ->orWhere('crm_contract_id', 'like', "%".$search."%");
    }
}
