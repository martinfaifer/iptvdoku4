<?php

namespace App\Jobs;

use App\Models\SatelitCard;
use App\Traits\SatelitCards\FindSatelitCardOnDeviceTemplateTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SearchIfSatCardIsUsedInDeviceJob implements ShouldQueue
{
    use Dispatchable, FindSatelitCardOnDeviceTemplateTrait, InteractsWithQueue, Queueable, SerializesModels;

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
            if (! $isUsed) {
                $satCard->update([
                    'status' => false,
                ]);
            } else {
                $satCard->update([
                    'status' => true,
                ]);
            }
        });
    }
}
