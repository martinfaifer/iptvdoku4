<?php

namespace App\Actions\Devices;

use App\Models\Alert;
use App\Models\Device;
use App\Services\Api\Ssh\ConnectService;

class CheckIfGpuWorkingAction
{
    public function __construct(public Device $device)
    {
        //
    }

    public function __invoke()
    {
        echo $this->device->name.PHP_EOL;
        try {
            $commandResponse = (new ConnectService(
                ip: $this->device->ip,
                username: $this->device->ssh->username,
                password: $this->device->ssh->password
            ))->send_command(command: 'nvidia-smi');

            if (str_contains($commandResponse, 'CUDA')) {
                Alert::where('type', 'gpu_problem')->where('item_id', $this->device->id)->delete();
            } else {
                if (! Alert::where('type', 'gpu_problem')->where('item_id', $this->device->id)->first()) {
                    Alert::create([
                        'type' => 'gpu_problem',
                        'item_id' => $this->device->id,
                        'message' => 'Zařízení '.$this->device->name.' nefunguje GPU',
                    ]);
                }
            }
        } catch (\Throwable $th) {
            // not logged in
            echo $this->device->name.' not logged in'.PHP_EOL;
            Alert::create([
                'type' => 'gpu_check_failed',
                'item_id' => $this->device->id,
                'message' => 'Nepodařilo se přihlásit do '.$this->device->name,
            ]);
        }
    }
}
