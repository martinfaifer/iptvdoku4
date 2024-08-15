<?php

namespace App\Actions\SystemLogs;

use App\Models\SystemLog;

class CreateSystemLogAction
{
    public function __construct(
        public string $type = 'warning',
        public string $action = "",
        public string $payload = ""
    ) {
        //
    }

    public function __invoke()
    {
        SystemLog::create([
            'type' => $this->type,
            'action' => $this->action,
            'payload' => $this->payload,
        ]);
    }
}
