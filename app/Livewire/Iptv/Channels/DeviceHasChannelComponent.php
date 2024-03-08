<?php

namespace App\Livewire\Iptv\Channels;

use App\Models\Device;
use App\Models\Channel;
use Livewire\Component;
use App\Models\ChannelOnLinux;
use Livewire\Attributes\Validate;
use App\Jobs\RestartStreamOnLinuxJob;
use Illuminate\Support\Facades\Cache;
use App\Services\Api\Ssh\ConnectService;
use App\Traits\Livewire\NotificationTrait;
use Illuminate\Database\Eloquent\Collection;
use App\Actions\Devices\RemoveChannelFromDeviceAction;

class DeviceHasChannelComponent extends Component
{
    use NotificationTrait;

    // public RemoveChannelFromDeviceAction $removeChannelFromDeviceAction;

    public ?Device $device;

    public ?Channel $channel;

    public $channelType;

    public null|array $nmsCahedData = null;

    public array $deviceInterfaces;

    public $deviceInterface;

    public bool $isBackup = false;

    public bool $updateModal = false;

    public bool $storeLinuxPathModal = false;

    public string $selectedInput = "";

    public string $selectedOutput = "";

    public $linuxPathToStream = null;

    #[Validate('required', message: "Vyplňte validní cestu")]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:255', message: "Maximální počet znaků je :max")]
    public string $path = "";

    public function mount()
    {
        $this->checkIfNeedToAddLinuxPath();
    }

    public function checkIfNeedToAddLinuxPath()
    {
        if ($this->device->category->name == "Linux") {
            if (!$this->linuxPathToStream = ChannelOnLinux
                ::where('device_id', $this->device->id)
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
            'path' => $this->path
        ]);

        $this->redirect_back();
        $this->success_alert("Upraveno");
        return $this->closeDialog();
    }

    public function getChannelNameByType()
    {
        if ($this->isBackup == true) {
            return $this->channelType . ":" . $this->channel->id . ":backup";
        }
        return $this->channelType . ":" . $this->channel->id;
    }

    public function openUpdateModal()
    {
        if (is_null($this->device->template)) {
            return $this->error_alert("Zařízení nemá šablonu, nelze upravovat!");
        }

        return $this->updateModal = true;
    }

    public function bindInput($input)
    {
        if ($this->selectedInput != $input) {
            return $this->selectedInput = $input;
        }
        return $this->selectedInput = "";
    }

    public function bindOutput($output)
    {
        if ($this->selectedOutput != $output) {
            return $this->selectedOutput = $output;
        }
        return $this->selectedOutput = "";
    }

    public function update()
    {
        $template = $this->device->template;
        if ($this->selectedInput != "") {
            array_push($template['inputs'][$this->selectedInput]['Vazba na kanály'],  $this->getChannelNameByType());
        }

        if ($this->selectedInput == "") {
            if (array_key_exists('inputs', $template)) {
                $template['inputs'] = $this->remove_channel_from_template($template['inputs']);
            }
        }

        if ($this->selectedOutput != "") {
            array_push($template['outputs'][$this->selectedOutput]['Vazba na kanály'],  $this->getChannelNameByType());
        }
        if ($this->selectedOutput == "") {
            if (array_key_exists('outputs', $template)) {
                $template['outputs'] = $this->remove_channel_from_template($template['outputs']);
            }
        }
        $this->device->update([
            'template' => $template
        ]);

        $this->redirect_back();
        $this->success_alert("Upraveno");
        return $this->closeDialog();
    }

    public function closeDialog()
    {
        $this->selectedInput = "";
        $this->selectedOutput = "";
        return $this->storeLinuxPathModal = false;
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
                'template' => $template
            ]);
        }

        $this->device->update([
            'has_channels' => $hasChannels
        ]);

        $this->redirect_back();

        return $this->success_alert("Odebráno");
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

    public function redirect_back()
    {
        if ($this->channelType == 'multicast') {
            $this->redirect("/channels/" . $this->channel->id . "/multicast", true);
        }

        if ($this->channelType == 'h264') {
            $this->redirect("/channels/" . $this->channel->id . "/h264", true);
        }

        if ($this->channelType == 'h265') {
            $this->redirect("/channels/" . $this->channel->id . "/h265", true);
        }
    }

    public function reboot_channel()
    {
        if (is_null($this->device->ssh)) {
            return $this->error_alert("Zařízení nemá nadefinován ssh přístup");
        }

        RestartStreamOnLinuxJob::dispatch(
            ip: $this->device->ip,
            username: $this->device->ssh->username,
            password: $this->device->ssh->password,
            path: 'bash' .$this->linuxPathToStream
        );

        return $this->success_alert("Příkaz k restartu byl odeslán");
    }

    public function render()
    {
        if (isset($this->device)) {
            $this->nmsCahedData = Cache::get('nms_' . $this->device->id);
        }
        return view('livewire.iptv.channels.device-has-channel-component', [
            'searcheableChannelName' => $this->getChannelNameByType()
        ]);
    }
}
