<?php

namespace App\Console\Commands;

use App\Actions\Slack\SendSlackNotificationAction;
use App\Models\RestartChannel;
use App\Models\Slack;
use App\Traits\Devices\GrapeTranscoders\GrapeTranscoderChannelTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class RestartChannelCommand extends Command
{
    use GrapeTranscoderChannelTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'channel:restart';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restart channel if can be';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $slackChannel = Slack::restartChannelAction()->first();

        $channelsCanBeRestarted = RestartChannel::with(['device', 'channel', 'stream_ip'])->get();

        if ($channelsCanBeRestarted->isEmpty()) {
            exit();
        }

        foreach ($channelsCanBeRestarted as $channelToRestart) {
            if (Cache::has('grape_transcoder_'.$channelToRestart->device_id)) {
                $cachedDataAboutTranscoder = Cache::get(('grape_transcoder_'.$channelToRestart->device_id));
                $listOfStreamsOnTranscoder = ($this->streams_on_transcoder($channelToRestart->device));

                if (! empty($listOfStreamsOnTranscoder)) {
                    foreach ($listOfStreamsOnTranscoder as $singleStream) {
                        $searcheableIp = $channelToRestart->stream_ip->ip;
                        if (! str_contains($searcheableIp, 'udp://')) {
                            $searcheableIp = 'udp://'.$searcheableIp;
                        }
                        if (! str_contains($searcheableIp, ':1234')) {
                            $searcheableIp = $searcheableIp.':1234';
                        }

                        if (
                            $singleStream['dst'] == $searcheableIp
                            || $singleStream['dst2'] == $searcheableIp
                            || $singleStream['dst3'] == $searcheableIp
                            || $singleStream['dst4'] == $searcheableIp
                        ) {
                            // stop stream
                            $this->pause_transcoding(
                                pid: $singleStream['pid'],
                                device: $channelToRestart->device
                            );
                            // send notification to slack
                            if ($slackChannel) {
                                (new SendSlackNotificationAction(
                                    text: 'Kanál '.$channelToRestart->channel->name." s IP $searcheableIp byl pozastaven na základě plánované akce",
                                    url: $slackChannel->url
                                ))();
                            }
                            // wait for 10s
                            sleep(10);
                            // start stream
                            $this->start_transcoding(
                                streamId: $singleStream['id'],
                                device: $channelToRestart->device
                            );
                            // send notification to slack
                            (new SendSlackNotificationAction(
                                text: 'Kanál '.$channelToRestart->channel->name." s IP $searcheableIp byl spuštěn na základě plánované akce",
                                url: $slackChannel->url
                            ))();
                        }
                    }
                }
            }
        }
    }
}
