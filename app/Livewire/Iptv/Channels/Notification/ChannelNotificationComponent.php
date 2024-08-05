<?php

namespace App\Livewire\Iptv\Channels\Notification;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\IptvDohledUrl;
use Livewire\Attributes\Validate;
use App\Models\ChannelQualityWithIp;
use App\Models\IptvDohledUrlsNotification;
use App\Traits\Livewire\NotificationTrait;
use App\Livewire\Forms\ChannelNotificationEmailForm;
use App\Livewire\Forms\ChannelNotificationSlackForm;
use App\Traits\Channels\CheckIfChannelIsInIptvDohledTrait;

class ChannelNotificationComponent extends Component
{
    use CheckIfChannelIsInIptvDohledTrait, NotificationTrait, WithPagination;

    public ChannelNotificationEmailForm $emailForm;
    public ChannelNotificationSlackForm $slackForm;

    public $ip;
    public $iptvDohledUrl;
    public bool $emailNotificationModal = false;
    public bool $slackChannelNotificationModal = false;

    #[Validate('required', message: "Musí být vyplňěno")]
    #[Validate('boolean', message: "Platný formát je pouze boolean")]
    public bool $can_notify = false;

    public function mount(string $ip)
    {
        $this->ip = $ip;
        $this->reload_data($ip);
    }

    #[On('channel_notification_refresh')]
    public function reload_data(string $ip)
    {
        $this->iptvDohledUrl = IptvDohledUrl::where('stream_url', $ip)->first();
        $this->can_notify = $this->iptvDohledUrl->can_notify;
    }

    public function goBack()
    {
        $unicastChannel = ChannelQualityWithIp::where('ip', $this->ip)->first();
        if ($unicastChannel) {
            if (!is_null($unicastChannel->h264_id)) {
                return $this->redirect('/channels/' . $unicastChannel->h264->channel_id . "/h264", true);
            }
            return $this->redirect('/channels/' . $unicastChannel->h265->channel_id . "/h265", true);
        }
    }

    public function chnage_if_can_be_notify()
    {
        $this->iptvDohledUrl->update([
            'can_notify' => $this->can_notify
        ]);
        $this->success_alert("Upraveno");
        return $this->redirect(url()->previous(), true);
    }

    public function openEmailNotificationModal()
    {
        return $this->emailNotificationModal = true;
    }

    public function openSlacklNotificationModal()
    {
        return $this->slackChannelNotificationModal = true;
    }

    public function add_email()
    {
        $this->emailForm->create($this->iptvDohledUrl);
        $this->closeDialog();
        $this->dispatch('channel_notification_refresh')->self();
        return $this->success_alert("Přidáno");
    }

    public function destroy_email($id)
    {
        $this->emailForm->destroy($id);
        return $this->success_alert("Odebráno");
    }

    public function destroy_slack($id)
    {
        $this->slackForm->destroy($id);
        return $this->success_alert("Odebráno");
    }

    public function add_slack()
    {
        $this->slackForm->create($this->iptvDohledUrl);
        $this->dispatch('channel_notification_refresh')->self();
        $this->closeDialog();
        return $this->success_alert("Přidáno");
    }

    public function closeDialog(): bool
    {
        $this->slackChannelNotificationModal = false;
        return $this->emailNotificationModal = false;
    }

    #[On('channel_notification_refresh')]
    public function render()
    {
        return view('livewire.iptv.channels.notification.channel-notification-component', [
            'emails' => IptvDohledUrlsNotification::where('iptv_dohled_url_id', $this->iptvDohledUrl->id)->where('email', "!=", null)->take(['id', 'email'])->paginate(),
            'email_headers' => [
                ['key' => 'email', 'label' => 'Email', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80']
            ],
            'slack_channels' => IptvDohledUrlsNotification::where('iptv_dohled_url_id', $this->iptvDohledUrl->id)->where('slack_channel', "!=", null)->take(['id', 'slack_channel'])->paginate(),
            'slack_headers' => [
                ['key' => 'slack_channel', 'label' => 'Slack kanál', 'class' => 'text-white/80'],
                ['key' => 'actions', 'label' => '', 'class' => 'text-white/80']
            ],
        ]);
    }
}
