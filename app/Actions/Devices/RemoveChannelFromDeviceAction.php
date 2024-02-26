<?php

namespace App\Actions\Devices;

use App\Models\Device;

class RemoveChannelFromDeviceAction
{
    public function __construct(public string $channelType, public int $channelId, public bool $isBackup = false)
    {
        //
    }

    public function __invoke(): void
    {
        Device::where('template', "!=", null)->each(function ($device) {
            $template = $device->template;

            if (array_key_exists('inputs', $template)) {
                $template['inputs'] = $this->remove_channel_from_template($template['inputs']);
            }
            if (array_key_exists('outputs', $template)) {
                $template['outputs'] = $this->remove_channel_from_template($template['outputs']);
            }

            $device->update([
                'template' => $template
            ]);
        });
    }

    public function remove_channel_from_template($interfaces)
    {
        foreach ($interfaces as $inputKey => $input) {
            if (in_array($this->getChannelNameByType(), $input['Vazba na kanály'])) {
                foreach ($input['Vazba na kanály'] as $key => $inChannel) {
                    if ($this->getChannelNameByType() == $inChannel) {
                        unset($interfaces[$inputKey]['Vazba na kanály'][$key]);
                    }
                }
            }
        }

        return $interfaces;
    }

    public function getChannelNameByType()
    {
        if ($this->isBackup == true) {
            return $this->channelType . ":" . $this->channelId . ":backup";
        }
        return $this->channelType . ":" . $this->channelId;
    }
}
