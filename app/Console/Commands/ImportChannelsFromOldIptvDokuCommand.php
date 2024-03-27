<?php

namespace App\Console\Commands;

use App\Models\Channel;
use App\Models\ChannelCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportChannelsFromOldIptvDokuCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:channels-from-old-iptv-doku';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all channels from old version of iptv doku';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $responseJson = Http::withBasicAuth(config('services.api.4.old_iptv_doku.user'), config('services.api.4.old_iptv_doku.password'))
            ->get(config('services.api.4.old_iptv_doku.url') . "/api/v1/public/channels")->json();

        foreach ($responseJson as $channel) {
            $path = null;
            if (!is_null($channel['logo'])) {
                $logo = str_replace("//", "/", $channel['logo']);
                $explodedLogo = explode("/", $logo);
                // dd($explodedLogo);
                $path = "public/Logos/" . $explodedLogo[4];
            }

            Channel::create([
                'name' => $channel['nazev'],
                'logo' => $path,
                'is_radio' => $channel['is_radio'] == true ? true : false,
                'is_multiscreen' => $channel['is_multiscreen'] == true ? true : false,
                'quality' => is_null($channel['kvalita']) ? "SD" : $channel['kvalita'],
                'category' => is_null($channel['kategorie']) ? null : ChannelCategory::where('name', $channel['kategorie'])->first()->id,
                'description' => $channel['popis'],
            ]);
        }
    }
}
