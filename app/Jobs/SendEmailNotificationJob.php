<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use App\Mail\SendNotificationEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $emailSubject, public string $text, public string|null $userWhoMakeChange, public string $eventType)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        User::where($this->eventType, true)->each(function ($user) {
            // send email to specific user
            Mail::to($user->email)->queue(new SendNotificationEmail(emailSubject: $this->emailSubject, emailContent: $this->text));
        });
    }
}