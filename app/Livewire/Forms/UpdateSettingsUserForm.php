<?php

namespace App\Livewire\Forms;

use App\Models\User;
use App\Traits\Users\CheckIfIsPinnedIptvWindowTrait;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateSettingsUserForm extends Form
{
    use CheckIfIsPinnedIptvWindowTrait;

    public ?User $user;

    #[Validate('required', message: 'Vyplňte jméno')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $first_name = '';

    #[Validate('required', message: 'Vyplňte příjmení')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $last_name = '';

    #[Validate('required', message: 'Vyberte roli')]
    #[Validate('exists:user_roles,id', message: 'Neexistující role')]
    public string|int|null $userRoleId = '';

    #[Validate('required', message: 'Chcete nebo nechcete být upozornění?')]
    #[Validate('bool', message: 'Neplatný formát')]
    public bool $notify_if_channel_change = false;

    #[Validate('required', message: 'Chcete nebo nechcete být upozornění?')]
    #[Validate('bool', message: 'Neplatný formát')]
    public bool $notify_if_added_new_wiki_content = false;

    #[Validate('required', message: 'Chcete nebo nechcete být upozornění?')]
    #[Validate('bool', message: 'Neplatný formát')]
    public bool $notify_if_weather_problem = false;

    #[Validate('required', message: 'Chcete nebo nechcete být upozornění?')]
    #[Validate('bool', message: 'Neplatný formát')]
    public bool $notify_if_too_many_channels_down = false;

    #[Validate('required', message: 'Chcete nebo nechcete být upozornění?')]
    #[Validate('bool', message: 'Neplatný formát')]
    public bool $notify_if_satelit_card_has_expiration = false;

    #[Validate('required', message: 'Chcete nebo nechcete být upozornění?')]
    #[Validate('bool', message: 'Neplatný formát')]
    public bool $notify_if_added_new_event = false;

    #[Validate('required', message: 'Chcete nebo nechcete připbout popup okno?')]
    #[Validate('bool', message: 'Neplatný formát')]
    public bool $iptv_monitoring_window = false;

    public function setUser(User $user): void
    {
        $this->user = $user;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->userRoleId = $user->user_role_id;
        $this->notify_if_channel_change = $user->notify_if_channel_change;
        $this->notify_if_added_new_wiki_content = $user->notify_if_added_new_wiki_content;
        $this->notify_if_weather_problem = $user->notify_if_weather_problem;
        $this->notify_if_too_many_channels_down = $user->notify_if_too_many_channels_down;
        $this->notify_if_satelit_card_has_expiration = $user->notify_if_satelit_card_has_expiration;
        $this->notify_if_added_new_event = $user->notify_if_added_new_event;

        $this->iptv_monitoring_window = $this->pinned($this->user->iptv_monitoring_window);
    }

    public function update(): void
    {
        $this->validate();

        $windowStatus = $this->convert_response_to_db_string($this->iptv_monitoring_window);

        if ($windowStatus == $this->user->iptv_monitoring_window) {
            $windowStatus = $this->user->iptv_monitoring_window;
        }

        $this->user->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'user_role_id' => $this->userRoleId,
            'notify_if_channel_change' => $this->notify_if_channel_change,
            'notify_if_added_new_wiki_content' => $this->notify_if_added_new_wiki_content,
            'notify_if_weather_problem' => $this->notify_if_weather_problem,
            'notify_if_too_many_channels_down' => $this->notify_if_too_many_channels_down,
            'iptv_monitoring_window' => $windowStatus,
        ]);
    }
}
