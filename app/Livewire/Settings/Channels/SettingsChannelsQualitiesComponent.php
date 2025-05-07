<?php

namespace App\Livewire\Settings\Channels;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ChannelQuality;
use App\Traits\Livewire\NotificationTrait;
use App\Livewire\Forms\CreateSettingsChannelsQualitiesForm;
use App\Models\ChannelQualityWithIp;

class SettingsChannelsQualitiesComponent extends Component
{
    use WithPagination, NotificationTrait;

    public CreateSettingsChannelsQualitiesForm $form;

    public string $query = '';
    public bool $createModal = false;

    public array $formats = [
        [
            'id' => "H264",
            'name' => "H264"
        ],
        [
            'id' => "H265",
            'name' => "H265"
        ]
    ];

    public function openCreateModal(): void
    {
        $this->createModal = true;
    }

    public function create(): void
    {
        $this->form->submit();
        $this->redirect(url()->previous(), true);
        $this->success_alert("Přidáno");
    }

    public function destroy(ChannelQuality $channelQuality): void
    {
        if(ChannelQualityWithIp::where('channel_quality_id', $channelQuality->id)->first()) {
            $this->error_alert("Má vazbu na kanál");
        } else {
            $channelQuality->delete();
        }
    }

    public function closeDialog(): void
    {
        $this->resetErrorBag();
        $this->createModal = false;
    }

    public function render()
    {
        return view('livewire.settings.channels.settings-channels-qualities-component', [
            'qualities' => ChannelQuality::search($this->query)->paginate(),
            'headers' => [
                ['key' => 'name', 'label' => 'Rozlišení', 'class' => 'dark:text-white/80'],
                ['key' => 'format', 'label' => 'Formát', 'class' => 'dark:text-white/80'],
                ['key' => 'bitrate', 'label' => 'Datový tok', 'class' => 'dark:text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'dark:text-white/80'],
            ],
        ]);
    }
}
