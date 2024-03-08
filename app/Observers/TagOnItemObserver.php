<?php

namespace App\Observers;

use App\Models\DeviceSsh;
use App\Models\TagOnItem;
use App\Jobs\DeleteDeviceSshJob;

class TagOnItemObserver
{
    public function created()
    {
        //
    }

    public function updated()
    {
        //
    }

    public function deleted(TagOnItem $tagOnItem)
    {
        //
    }
}
