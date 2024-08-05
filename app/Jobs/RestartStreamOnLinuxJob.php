<?php

namespace App\Jobs;

use App\Services\Api\Ssh\ConnectService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RestartStreamOnLinuxJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public string $ip, public string $username, public string $password, public string $path)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $connection = (new ConnectService(
            ip: $this->ip,
            username: $this->username,
            password: $this->password
        ));

        $connection->send_command('bash ' . $this->path);
    }
}
