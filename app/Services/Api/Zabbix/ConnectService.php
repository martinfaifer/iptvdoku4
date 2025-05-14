<?php

namespace App\Services\Api\Zabbix;

use App\Models\Device;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use App\Traits\Api\RequestTypeTrait;
use Illuminate\Support\Facades\Http;

class ConnectService
{
    use RequestTypeTrait;

    public function login()
    {
        $response = Http::post(config('services.api.zabbix.url') . '/api_jsonrpc.php', [
            'jsonrpc' => '2.0',
            'method'  => 'user.login',
            'params'  => [
                'user'     => config('services.api.zabbix.user'),
                'password' => config('services.api.zabbix.password'),
            ],
            'id' => 1,
        ]);

        return $response['result'];
    }

    public function getGraphIdFromItem($hostid)
    {
        $auth = $this->login();

        $response = Http::post(config('services.api.zabbix.url').'/api_jsonrpc.php', [
            'jsonrpc' => '2.0',
            'method'  => 'graph.get',
            'params'  => [
                'output' => ['graphid', 'name'],
                'hostids' => [$hostid],
            ],
            'auth' => $auth,
            'id' => 2,
        ]);

        $graphs = $response['result'];

        return $graphs;
    }

    public function getDeviceChart(int|string $graphid)
    {
        $zabbixUrl = config('services.api.zabbix.url');
        $client = new Client(['base_uri' => $zabbixUrl]);

        $cookieJar = new CookieJar();

        $response = $client->post('/index.php', [
            'form_params' => [
                'name' => config('services.api.zabbix.user'),
                'password' => config('services.api.zabbix.password'),
                'autologin' => 1,
                'enter' => 'Sign in',
            ],
            'cookies' => $cookieJar,
        ]);

        $response = $client->get(
            "/chart2.php?graphid={$graphid}&from=now-1h&to=now",
            ['cookies' => $cookieJar]
        );

        $imageData = 'data:image/png;base64,' . base64_encode($response->getBody()->getContents());

        return $imageData;
    }

    public function dataTest($hostid)
    {
        $auth = $this->login();

        $response = Http::post(config('services.api.zabbix.url').'/api_jsonrpc.php', [
            'jsonrpc' => '2.0',
            'method'  => 'item.get',
            'params'  => [
                'output' => ['itemid', 'name'],
                'hostids' => [$hostid],
            ],
            'auth' => $auth,
            'id' => 1,
        ]);

        $graphs = $response['result'];

        if (count($graphs) === 0) {
            return response()->json(['message' => 'No graph found for this item.'], 404);
        }

        return response()->json([
            'graphid' => $graphs[0]['graphid'],
            'name' => $graphs[0]['name'],
        ]);
    }
}
