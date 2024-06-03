<?php

namespace App\Livewire\Iptv\Channels;

use App\Actions\Devices\RemoveChannelFromDeviceAction;
use App\Jobs\RestartStreamOnLinuxJob;
use App\Models\Channel;
use App\Models\ChannelOnLinux;
use App\Models\Device;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DeviceHasChannelComponent extends Component
{
    use NotificationTrait;

    public ?Device $device;

    public ?Channel $channel;

    public $channelType;

    public ?array $nmsCahedData = null;

    public array $deviceInterfaces;

    public $deviceInterface;

    public bool $isBackup = false;

    public bool $updateModal = false;

    public bool $storeLinuxPathModal = false;

    public string $selectedInput = '';

    public string $selectedOutput = '';

    public $linuxPathToStream = null;

    #[Validate('required', message: 'Vyplňte validní cestu')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $path = '';

    public function mount(Device $device)
    {
        $this->device = $device->load('category');
        $this->checkIfNeedToAddLinuxPath();
    }

    public function checkIfNeedToAddLinuxPath()
    {
        if ($this->device->category->name == 'Linux') {
            if (!$this->linuxPathToStream = ChannelOnLinux::where('device_id', $this->device->id)
                ->where('channel_type', $this->channelType)
                ->where('channel_id', $this->channel->id)
                ->first()) {
                return $this->storeLinuxPathModal = true;
            }

            return $this->linuxPathToStream;
        }
    }

    public function store_path()
    {
        $this->validate();
        ChannelOnLinux::create([
            'device_id' => $this->device->id,
            'channel_type' => $this->channelType,
            'channel_id' => $this->channel->id,
            'path' => $this->path,
        ]);

        $this->redirect(url()->previous(), true);
        $this->success_alert('Upraveno');

        return $this->closeDialog();
    }

    public function getChannelNameByType()
    {
        if ($this->isBackup == true) {
            return $this->channelType . ':' . $this->channel->id . ':backup';
        }

        return $this->channelType . ':' . $this->channel->id;
    }

    public function openUpdateModal()
    {
        if (is_null($this->device->template)) {
            return $this->error_alert('Zařízení nemá šablonu, nelze upravovat!');
        }

        return $this->updateModal = true;
    }

    public function bindInput($input)
    {
        if ($this->selectedInput != $input) {
            return $this->selectedInput = $input;
        }

        return $this->selectedInput = '';
    }

    public function bindOutput($output)
    {
        if ($this->selectedOutput != $output) {
            return $this->selectedOutput = $output;
        }

        return $this->selectedOutput = '';
    }

    public function update()
    {
        $template = $this->device->template;
        if ($this->selectedInput != '') {
            array_push($template['inputs'][$this->selectedInput]['Vazba na kanály'], $this->getChannelNameByType());
        }

        if ($this->selectedInput == '') {
            if (array_key_exists('inputs', $template)) {
                $template['inputs'] = $this->remove_channel_from_template($template['inputs']);
            }
        }

        if ($this->selectedOutput != '') {
            if (array_key_exists('outputs', $template)) {
                array_push($template['outputs'][$this->selectedOutput]['Vazba na kanály'], $this->getChannelNameByType());
            }
        }
        if ($this->selectedOutput == '') {
            if (array_key_exists('outputs', $template)) {
                $template['outputs'] = $this->remove_channel_from_template($template['outputs']);
            }
        }

        if ($this->selectedOutput != '') {
            if (array_key_exists('modules', $template)) {
                array_push($template['modules'][$this->selectedOutput]['Vazba na kanály'], $this->getChannelNameByType());
            }
        }

        if ($this->selectedOutput == '') {
            if (array_key_exists('modules', $template)) {
                $template['modules'] = $this->remove_channel_from_template($template['modules']);
            }
        }
        $this->device->update([
            'template' => $template,
        ]);

        $this->redirect(url()->previous(), true);
        $this->success_alert('Upraveno');

        return $this->closeDialog();
    }

    public function closeDialog()
    {
        $this->selectedInput = '';
        $this->selectedOutput = '';

        $this->storeLinuxPathModal = false;

        return $this->updateModal = false;
    }

    public function delete()
    {
        $hasChannels = $this->device->has_channels;

        foreach ($hasChannels as $key => $hasChannel) {
            if ($hasChannel == $this->getChannelNameByType()) {
                unset($hasChannels[$key]);
            }
        }

        if (!is_null($this->device->template)) {
            $template = $this->device->template;

            if (array_key_exists('inputs', $template)) {
                $template['inputs'] = $this->remove_channel_from_template($template['inputs']);
            }
            if (array_key_exists('outputs', $template)) {
                $template['outputs'] = $this->remove_channel_from_template($template['outputs']);
            }

            $this->device->update([
                'template' => $template,
            ]);
        }

        $this->device->update([
            'has_channels' => $hasChannels,
        ]);

        $this->redirect(url()->previous(), true);
        return $this->success_alert('Odebráno');
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

    public function reboot_channel()
    {
        if (is_null($this->device->ssh)) {
            return $this->error_alert('Zařízení nemá nadefinován ssh přístup');
        }

        RestartStreamOnLinuxJob::dispatch(
            ip: $this->device->ip,
            username: $this->device->ssh->username,
            password: $this->device->ssh->password,
            path: 'bash' . $this->linuxPathToStream
        );

        return $this->success_alert('Příkaz k restartu byl odeslán');
    }

    public function render()
    {
        if (isset($this->device)) {
            $this->nmsCahedData = Cache::get('nms_' . $this->device->id);
        }

        return view('livewire.iptv.channels.device-has-channel-component', [
            'searcheableChannelName' => $this->getChannelNameByType(),
        ]);
    }
}
