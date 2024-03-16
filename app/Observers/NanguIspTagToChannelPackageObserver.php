<?php

namespace App\Observers;

use App\Models\NanguIspTagToChannelPackage;

class NanguIspTagToChannelPackageObserver
{
    public function created(NanguIspTagToChannelPackage $nanguIspTagToChannelPackage)
    {
        // $nanguIspTagToChannelPackage->tag_id;
    }

    public function updated(NanguIspTagToChannelPackage $nanguIspTagToChannelPackage)
    {
        //
    }

    public function deleted(NanguIspTagToChannelPackage $nanguIspTagToChannelPackage)
    {
        //
    }
}
