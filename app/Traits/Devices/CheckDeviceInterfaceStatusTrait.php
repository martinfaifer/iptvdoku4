<?php

namespace App\Traits\Devices;

use App\Actions\Slack\SendSlackNotificationAction;
use App\Models\Device;
use App\Models\Slack;

trait CheckDeviceInterfaceStatusTrait
{
    public function check_interface_status(Device $device, string $newStatus, string $oldStatus, string $interface): void
    {
        if (! str_contains($newStatus, '/') || ! str_contains($oldStatus, '/')) {
            if ($oldStatus != $newStatus) {
                $slackChannel = Slack::deviceError()->first();
                if ($slackChannel) {
                    (new SendSlackNotificationAction(
                        url: $slackChannel->url,
                        text: ':fire: U zařízení ' . $device->name . ' a portu ' . str_replace('status', '', $interface) . ' se změnil status z ' . $oldStatus . ' na ' . $newStatus
                    ))();
                }
            }
        }
    }
}
