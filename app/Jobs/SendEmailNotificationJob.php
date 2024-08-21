<?php

namespace App\Jobs;

use App\Mail\SendNotificationEmail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class SendEmailNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $emailSubject, public string $text, public ?string $userWhoMakeChange, public string $eventType)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $thirtyMinutesInSecondsTtl = 1800; // prevention of spamming
        User::where($this->eventType, true)->each(function ($user) use ($thirtyMinutesInSecondsTtl) {
            // send email to specific user
            if (! Cache::has($user->id . '_' . $this->eventType)) {
                Cache::put($user->id . '_' . $this->eventType, 'is_send', $thirtyMinutesInSecondsTtl);
                Mail::to($user->email)->queue(new SendNotificationEmail(emailSubject: $this->emailSubject, emailContent: $this->text));
            }
        });
    }
}
