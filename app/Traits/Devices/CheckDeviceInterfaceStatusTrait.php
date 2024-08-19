<?php

namespace App\Traits\Devices;

use App\Actions\Slack\SendSlackNotificationAction;
use App\Models\Slack;

trait CheckDeviceInterfaceStatusTrait
{
    public function check_interface_status($device, $newStatus, $oldStatus, $interface)
    {
        // compare oldStatus with new status
        if ($newStatus != "n/a") {
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
