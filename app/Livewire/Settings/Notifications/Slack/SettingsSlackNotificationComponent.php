<?php

namespace App\Livewire\Settings\Notifications\Slack;

use App\Livewire\Forms\CreateSettingsSlackNotificationForm;
use App\Livewire\Forms\UpdateSettingsSlackNotificationForm;
use App\Models\Slack;
use App\Traits\Livewire\NotificationTrait;
use App\Traits\Slack\TranslateActionsTrait;
use Illuminate\Contracts\View\Factory;
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

    public function mount(): void
    {
        $this->slackActions = $this->translate();
    }

    public function openCreateModal(): void
    {
        $this->createModal = true;
    }

    public function closeDialog(): void
    {
        $this->createForm->reset();
        $this->updateForm->reset();

        $this->editModal = false;
        $this->createModal = false;
    }

    public function create(): mixed
    {
        $this->createForm->create();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Přidáno');
    }

    public function edit(Slack $slack): void
    {
        $this->updateForm->setChannel($slack);

        $this->editModal = true;
    }

    public function update(): mixed
    {
        $this->updateForm->update();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Upraveno');
    }

    public function destroy(Slack $slack): mixed
    {
        $slack->delete();

        $this->redirect(url()->previous(), true);

        return $this->success_alert('Odebráno');
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
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
