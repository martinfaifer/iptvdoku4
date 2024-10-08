<?php

namespace App\Traits\Models;

use App\Models\NanguIsp;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait NanguIspTrait
{
    public function nanguIsp(): BelongsTo  // @phpstan-ignore-line
    {
        return $this->belongsTo(NanguIsp::class, 'nangu_isp_id', 'id');  // @phpstan-ignore-line
    }
}
