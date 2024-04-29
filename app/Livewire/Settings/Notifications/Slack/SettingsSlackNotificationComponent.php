<?php

namespace App\Livewire\Settings\Notifications\Slack;

use App\Livewire\Forms\CreateSettingsSlackNotificationForm;
use App\Livewire\Forms\UpdateSettingsSlackNotificationForm;
use App\Models\Slack;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Slack\TranslateActionsTrait;
use Livewire\Component;
use Livewire\WithPagination;

class SettingsSlackNotificationComponent extends Component
{
    use NotificationTrait, TranslateActionsTrait, WithPagination;

    public string $query = '';

    public bool $createModal = false;

    public bool $editModal = false;

    public CreateSettingsSlackNotificationForm $createForm;

    public UpdateSettingsSlackNotificationForm $updateForm;

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
        $this->updateForm->reset();

        $this->editModal = false;
        $this->createModal = false;
    }

    public function create()
    {
        $this->createForm->create();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Přidáno');
    }

    public function edit(Slack $slack)
    {
        $this->updateForm->setChannel($slack);

        return $this->editModal = true;
    }

    public function update()
    {
        $this->updateForm->update();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Upraveno');
    }

    public function destroy(Slack $slack)
    {
        $slack->delete();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Odebráno');
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
            'slackChannels' => Slack::search($this->query)->paginate(5),
        ]);
    }
}
