<?php

namespace App\Jobs;

use App\Models\IptvDohledUrl;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateStreamUrlInDohledIfIsItJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $new_stream_url, public string $original_stream_url, public string $channel_description)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // check if is original url in dohled
        $checkIfIsDohled = IptvDohledUrl::streamUrl($this->original_stream_url)->first();
        if ($checkIfIsDohled) {
            DeleteStreamFromIptvDohledJob::dispatch($this->original_stream_url);
            $checkIfIsDohled->delete();
            // store new
            StoreStreamToIptvDohledJob::dispatch(
                $this->channel_description,
                $this->new_stream_url
            );
        }
    }
}
