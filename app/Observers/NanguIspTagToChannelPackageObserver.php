<?php

namespace App\Observers;

use App\Models\NanguIspTagToChannelPackage;

class NanguIspTagToChannelPackageObserver
{
    public function created(NanguIspTagToChannelPackage $nanguIspTagToChannelPackage): void
    {
        // $nanguIspTagToChannelPackage->tag_id;
    }

    public function updated(NanguIspTagToChannelPackage $nanguIspTagToChannelPackage): void
    {
        //
    }

    public function deleted(NanguIspTagToChannelPackage $nanguIspTagToChannelPackage): void
    {
        //
    }
}
