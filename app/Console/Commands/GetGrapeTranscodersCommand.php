<?php

namespace App\Console\Commands;

use App\Models\Device;
use App\Services\Api\GrapeTranscoders\ConnectService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class GetGrapeTranscodersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grape_transcoders:get_transcoders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Getting all transcoders belongs to Grapesc and running on controller ... for more info .env';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $serverResponse = (new ConnectService(endpointType: 'transcoders'))->connect();

        foreach ($serverResponse as $responseData) {
            $device = Device::where('ip', $responseData['ip'])->first();
            if ($device) {
                Cache::put(
                    'grape_transcoder_'.$device->id,
                    $responseData,
                    3600
                );
            }
        }
    }
}
