<?php

namespace App\Models;

use App\Observers\NanguIspTagToChannelPackageObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(NanguIspTagToChannelPackageObserver::class)]
class NanguIspTagToChannelPackage extends Model
{
    protected $fillable = [
        'nangu_isp_id', 'tag_id', 'nangu_channel_package_name',
    ];

    public function nangu_isp(): BelongsTo
    {
        return $this->belongsTo(NanguIsp::class, 'nangu_isp_id');
    }

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}
