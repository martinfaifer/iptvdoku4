<?php

namespace App\Livewire\Iptv\Channels;

use App\Models\Device;
use App\Models\Channel;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\ChannelOnLinux;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use App\Jobs\RestartStreamOnLinuxJob;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\View\Factory;
use App\Traits\Livewire\NotificationTrait;

class DeviceHasChannelComponent extends Component
{
    use NotificationTrait;

    #[Locked]
    public ?Device $device;

    #[Locked]
    public ?Channel $channel;

    #[Locked]
    public string $channelType = '';

    public ?array $nmsCahedData = null;

    public array $deviceInterfaces;

    public mixed $deviceInterface;

    public bool $isBackup = false;

    public bool $updateModal = false;

    public bool $storeLinuxPathModal = false;

    public string $selectedInput = '';

    public string $selectedOutput = '';

    public mixed $linuxPathToStream = null;

    #[Validate('required', message: 'Vyplňte validní cestu')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $path = '';

    public function mount(Device $device): void
    {
        $this->device = $device->load('category');
    }

    public function checkIfNeedToAddLinuxPath(): void
    {
        if ($this->device->category->name == 'Linux') {
            if (! $this->linuxPathToStream = ChannelOnLinux::where('device_id', $this->device->id)
                ->where('channel_type', $this->channelType)
                ->where('channel_id', $this->channel->id)
                ->first()) {
                $this->storeLinuxPathModal = true;
            }
        }
    }

    public function store_path(): mixed
    {
        $this->validate();
        ChannelOnLinux::create([
            'device_id' => $this->device->id,
            'channel_type' => $this->channelType,
            'channel_id' => $this->channel->id,
            'path' => $this->path,
        ]);

        $this->dispatch('refresh_device_component')->self();
        $this->path = '';
        $this->closeDialog();

        return $this->success_alert('Upraveno');
    }

    public function getChannelNameByType(): string
    {
        if ($this->isBackup == true) {
            return $this->channelType . ':' . $this->channel->id . ':backup';
        }

        return $this->channelType . ':' . $this->channel->id;
    }

    public function openUpdateModal(): mixed
    {
        if (is_null($this->device->template)) {  // @phpstan-ignore-line
            return $this->error_alert('Zařízení nemá šablonu, nelze upravovat!');
        }

        return $this->updateModal = true;
    }

    public function bindInput(string $input): void
    {
        if ($this->selectedInput != $input) {
            $this->selectedInput = $input;
        } else {
            $this->selectedInput = '';
        }
    }

    public function bindOutput(string $output): void
    {
        if ($this->selectedOutput != $output) {
            $this->selectedOutput = $output;
        } else {
            $this->selectedOutput = '';
        }
    }

    public function update(): mixed
    {
        $template = $this->device->template;  // @phpstan-ignore-line
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

        // $this->redirect(url()->previous(), true);
        $this->dispatch('refresh_channel_has_devices_' . $this->channelType . '_' . $this->channel->id);
        $this->closeDialog();

        return $this->success_alert('Upraveno');
    }

    public function closeDialog(): void
    {
        $this->selectedInput = '';
        $this->selectedOutput = '';

        $this->storeLinuxPathModal = false;

        $this->updateModal = false;
    }

    public function delete(): mixed
    {
        $hasChannels = $this->device->has_channels;

        foreach ($hasChannels as $key => $hasChannel) {
            if ($hasChannel == $this->getChannelNameByType()) {
                unset($hasChannels[$key]);
            }
        }

        if (! is_null($this->device->template)) {  // @phpstan-ignore-line
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

        // $this->redirect(url()->previous(), true);
        $this->dispatch('refresh_channel_has_devices_' . $this->channelType . '_' . $this->channel->id);

        return $this->success_alert('Odebráno');
    }

    public function remove_channel_from_template(array $interfaces): array
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

    public function reboot_channel(): mixed
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

    public function delete_linux_path(): mixed
    {
        ChannelOnLinux::where('device_id', $this->device->id)
            ->where('channel_type', $this->channelType)
            ->where('channel_id', $this->channel->id)
            ->delete();

        $this->dispatch('refresh_device_component')->self();

        return $this->success_alert('Odebráno');
    }

    #[On('refresh_device_component')]
    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        $this->checkIfNeedToAddLinuxPath();

        if (isset($this->device)) {
            $this->nmsCahedData = Cache::get('nms_' . $this->device->id);
        }

        return view('livewire.iptv.channels.device-has-channel-component', [
            'searcheableChannelName' => $this->getChannelNameByType(),
        ]);
    }
}
