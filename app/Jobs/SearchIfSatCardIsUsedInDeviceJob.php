<?php

namespace App\Jobs;

use App\Models\Device;
use App\Models\SatelitCard;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Traits\SatelitCards\FindSatelitCardOnDeviceTemplateTrait;

class SearchIfSatCardIsUsedInDeviceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, FindSatelitCardOnDeviceTemplateTrait;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        SatelitCard::each(function ($satCard) {

            $isUsed = $this->find_card_in_device_template($satCard);
            if (!$isUsed) {
                $satCard->update([
                    'status' => false
                ]);
            } else {
                $satCard->update([
                    'status' => true
                ]);
            }
        });
    }
}
