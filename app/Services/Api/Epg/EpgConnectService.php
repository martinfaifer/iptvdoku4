<?php

namespace App\Services\Api\Epg;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class EpgConnectService
{
    public string $url = '';

    public function __construct()
    {
        $this->url = str_replace('%key%', config('services.api.1.epg.key'), config('services.api.1.epg.url'));
    }

    public function connect(?string $query = null, string $cacheKey = 'channelEpgIds')
    {
        if (!is_null($query)) {
            $this->url = $this->url . $query;
        }

        $httpResponse = Http::get($this->url);

        if ($httpResponse->ok()) {

            if (@simplexml_load_string($httpResponse->body())) {
                $result = $this->xml2arr($httpResponse->body(), is_null($query) ? true : false);

                Cache::put($cacheKey, $result, 3600);
            }

            return $httpResponse->json();
        }
    }

    protected function xml2arr($xml, $isShifted = false)
    {
        $new = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);

        $con = json_encode($new);

        $newArr = json_decode($con, true);

        if (!$isShifted) {
            return $newArr;
        }

        return array_shift($newArr);
    }

    public function get_epg_name_by_id($epgId)
    {
        if (is_null($epgId)) {
            return '';
        }
        $epgs = Cache::get('channelEpgIds');

        if (is_null($epgs)) {
            return '';
        }

        foreach ($epgs as $epg) {
            if ($epgId == $epg['id']) {
                return $epg['name'];
            }
        }

        return '';
    }

    public function get_channel_epg(string|int $epgId, string $fromDate, string $toDate)
    {
        $this->url = str_replace('channel', 'grapesc', $this->url) . "&channel=$epgId&date_from=$fromDate&date_to=$toDate";
        $httpResponse = Http::get($this->url);
        if ($httpResponse->ok()) {

            if (@simplexml_load_string($httpResponse->body())) {
                return $result = $this->xml2arr($httpResponse->body());
            }

            return $httpResponse->json();
        }
    }
}
