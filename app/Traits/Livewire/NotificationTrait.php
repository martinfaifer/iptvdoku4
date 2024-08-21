<?php

namespace App\Traits\Livewire;

use Mary\Traits\Toast;

trait NotificationTrait
{
    use Toast;

    public function success_alert(string $text): mixed
    {
        return $this->toast(
            type: 'success',
            title: $text,
            position: 'toast-top toast-end',    // optional (daisyUI classes)
            icon: 'o-check',
            css: 'alert-success text-white/80 w-96 z-[99999]',     // Optional (daisyUI classes)
            timeout: 5000,                      // optional (ms)
        );
    }

    public function error_alert(string $text = 'Něco se nepovedlo'): mixed
    {
        return $this->error(
            $text,
            timeout: 5000,
            position: 'toast-top toast-end',
            css: 'alert-warning text-white/80 w-96'
        );
    }
}
