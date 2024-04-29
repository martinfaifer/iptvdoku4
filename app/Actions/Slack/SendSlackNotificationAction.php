<?php

namespace App\Actions\Slack;

use App\Jobs\SendSlackMesssageJob;

class SendSlackNotificationAction
{
    /**
     * text is what is saw in message
     * url is slack endpoint
     */
    public function __construct(public string $text, public string $url)
    {
    }

    public function __invoke()
    {
        SendSlackMesssageJob::dispatch(
            $this->url,
            $this->text
        );
    }
}
