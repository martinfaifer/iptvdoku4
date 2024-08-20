<?php

namespace App\Traits\Devices;

use App\Actions\Slack\SendSlackNotificationAction;
use App\Models\Slack;

trait CheckDeviceInterfaceStatusTrait
{
    public function check_interface_status(object $device, string $newStatus, string $oldStatus, string $interface)
    {
        if ($newStatus != "n/a" || $oldStatus != "n/a") {
            if ($oldStatus != $newStatus) {
                $slackChannel = Slack::deviceError()->first();
                if ($slackChannel) {
                    (new SendSlackNotificationAction(
                        url: $slackChannel->url,
                        text: ":fire: U zařízení " . $device->name . " a portu " . str_replace("status", "", $interface) . " se změnil status z " . $oldStatus . " na " . $newStatus
                    ))();
                }
            }
        }
    }
}
