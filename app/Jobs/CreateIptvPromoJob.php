<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Actions\Nangu\CreatePromoUserAction;

class CreateIptvPromoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public ?string $name = null,
        public ?string $surname = null,
        public ?string $locality = null,
        public ?string $phone = null,
        public ?string $email = null,
        public string $expiration
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        (new CreatePromoUserAction())->execute(
            name: $this->name,
            surname: $this->surname,
            locality: $this->locality,
            phone: $this->phone,
            email: $this->email,
            expiration: $this->expiration
        );
    }
}
