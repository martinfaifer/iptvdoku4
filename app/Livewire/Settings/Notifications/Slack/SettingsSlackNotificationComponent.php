<?php

namespace App\Livewire\Settings\Notifications\Slack;

use App\Models\Slack;
use Livewire\Component;
use Livewire\WithPagination;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Slack\TranslateActionsTrait;
use App\Livewire\Forms\CreateSettingsSlackNotificationForm;

class SettingsSlackNotificationComponent extends Component
{
    use NotificationTrait, WithPagination, TranslateActionsTrait;

    public string $query = "";

    public bool $createModal = false;

    public CreateSettingsSlackNotificationForm $createForm;

    public array $slackActions = [];

    public function mount()
    {
        $this->slackActions = $this->translate();
    }

    public function openCreateModal()
    {
        return $this->createModal = true;
    }

    public function closeDialog()
    {
        $this->createForm->reset();

        $this->createModal = false;
    }


    public function create()
    {
        $this->createForm->create();

        $this->redirect("/settings/notifications/slack", true);
        return $this->success_alert("Přidáno");
    }

    public function render()
    {
        return view('livewire.settings.notifications.slack.settings-slack-notification-component', [
            'headers' => [
                ['key' => 'url', 'label' => 'Url', 'class' => 'text-white/80'],
                ['key' => 'description', 'label' => 'Popis', 'class' => 'text-white/80'],
                ['key' => 'action', 'label' => 'Vazba na akci', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80'],
            ],
            'slackChannels' => Slack::search($this->query)->paginate(5)
        ]);
    }
}
