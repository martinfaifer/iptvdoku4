<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\User;
use Livewire\Attributes\Validate;

class UserNotificationForm extends Form
{
    public ?User $user;

    #[Validate('required', message: "Musí být vyplňěno")]
    #[Validate('boolean', message: "Hodnota musí být boolean")]
    public bool $notify_if_channel_change = false;

    #[Validate('required', message: "Musí být vyplňěno")]
    #[Validate('boolean', message: "Hodnota musí být boolean")]
    public bool $notify_if_added_new_wiki_content = false;

    #[Validate('required', message: "Musí být vyplňěno")]
    #[Validate('boolean', message: "Hodnota musí být boolean")]
    public bool $notify_if_weather_problem = false;

    #[Validate('required', message: "Musí být vyplňěno")]
    #[Validate('boolean', message: "Hodnota musí být boolean")]
    public bool $notify_if_too_many_channels_down = false;

    #[Validate('required', message: "Musí být vyplňěno")]
    #[Validate('boolean', message: "Hodnota musí být boolean")]
    public bool $notify_if_satelit_card_has_expiration = false;

    #[Validate('required', message: "Musí být vyplňěno")]
    #[Validate('boolean', message: "Hodnota musí být boolean")]
    public bool $notify_if_added_new_event = false;

    #[Validate('required', message: "Musí být vyplňěno")]
    #[Validate('boolean', message: "Hodnota musí být boolean")]
    public bool $notify_if_upload_new_banner = false;

    #[Validate('required', message: "Musí být vyplňěno")]
    #[Validate('boolean', message: "Hodnota musí být boolean")]
    public bool $notify_if_channel_was_added_to_promo = false;
    public function setNotifications(User $user)
    {
        $this->user = $user;
        $this->notify_if_channel_change = $user->notify_if_channel_change;
        $this->notify_if_added_new_wiki_content = $user->notify_if_added_new_wiki_content;
        $this->notify_if_weather_problem = $user->notify_if_weather_problem;
        $this->notify_if_too_many_channels_down = $user->notify_if_too_many_channels_down;
        $this->notify_if_satelit_card_has_expiration = $user->notify_if_satelit_card_has_expiration;
        $this->notify_if_added_new_event = $user->notify_if_added_new_event;
        $this->notify_if_upload_new_banner = $user->notify_if_upload_new_banner;
        $this->notify_if_channel_was_added_to_promo = $user->notify_if_channel_was_added_to_promo;
    }

    public function update()
    {
        $this->validate();

        $this->user->update([
            'notify_if_channel_change' => $this->notify_if_channel_change,
            'notify_if_added_new_wiki_content' => $this->notify_if_added_new_wiki_content,
            'notify_if_weather_problem' => $this->notify_if_weather_problem,
            'notify_if_too_many_channels_down' => $this->notify_if_too_many_channels_down,
            'notify_if_satelit_card_has_expiration' => $this->notify_if_satelit_card_has_expiration,
            'notify_if_added_new_event' => $this->notify_if_added_new_event,
            'notify_if_upload_new_banner' => $this->notify_if_upload_new_banner,
            'notify_if_channel_was_added_to_promo' => $this->notify_if_channel_was_added_to_promo
        ]);

        $this->reset();
    }
}
