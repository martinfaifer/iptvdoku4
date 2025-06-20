<?php

namespace App\Actions\Devices;

use App\Models\Alert;
use App\Models\Slack;
use App\Models\Device;
use App\Services\Api\Ssh\ConnectService;
use App\Actions\Slack\SendSlackNotificationAction;

class CheckCpuUsageAction
{
    public function __construct(public Device $device)
    {
        //
    }

    public function __invoke(): void
    {
        // try {
        $commandResponse = (new ConnectService(
            ip: $this->device->ip,
            username: $this->device->ssh->username,
            password: $this->device->ssh->password
        ))->send_command(command: "top -bn1 | grep \"Cpu(s)\" | awk '{print 100 - $8\"%\"}'");

        $commandResponseAsArray = explode("\n", $commandResponse);
        $reverserdCommandResponseAsArray = array_reverse($commandResponseAsArray);
        $cpuUsage = (intval($reverserdCommandResponseAsArray[1]));

        if ($cpuUsage <= 50) {
            Alert::where('type', 'cpu_high_usage')->where('item_id', $this->device->id)->delete();
        } else {
            if (! Alert::where('type', 'cpu_high_usage')->where('item_id', $this->device->id)->first()) {
                Alert::create([
                    'type' => 'cpu_high_usage',
                    'item_id' => $this->device->id,
                    'message' => 'Zařízení ' . $this->device->name . ' má CPU zátěž ' . $cpuUsage . "%",
                ]);
            }
            if (Slack::gpuProblemNotificationAction()->first()) {
                foreach (Slack::gpuProblemNotificationAction()->get() as $slack) {
                    (new SendSlackNotificationAction(
                        text: 'Zařízení ' . $this->device->name . ' má CPU zátěž ' . $cpuUsage . "%",
                        url: $slack->url
                    ))();
                }
            }
        }
        // } catch (\Throwable $th) {
        // not logged in
        // Alert::create([
        //     'type' => 'gpu_check_failed',
        //     'item_id' => $this->device->id,
        //     'message' => 'Nepodařilo se přihlásit do '.$this->device->name,
        // ]);
        // send alert to slack
        // if (Slack::gpuProblemNotificationAction()->first()) {
        //     foreach (Slack::gpuProblemNotificationAction()->get() as $slack) {
        //         (new SendSlackNotificationAction(
        //             text: 'Nepodařilo se přihlásit do '.$this->device->name,
        //             url: $slack->url
        //         ))();
        //     }
        // }
        // }
    }
}
