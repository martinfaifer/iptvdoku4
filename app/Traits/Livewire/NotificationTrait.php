<?php

namespace App\Traits\Livewire;

use Mary\Traits\Toast;

trait NotificationTrait
{
    use Toast;

    public function success_alert(string $text)
    {
        $this->toast(
            type: 'success',
            title: $text,
            position: 'toast-top toast-end',    // optional (daisyUI classes)
            icon: 'o-check',
            css: 'alert-success text-white w-96',     // Optional (daisyUI classes)
            timeout: 5000,                      // optional (ms)
        );
    }

    public function error_alert(string $text = 'Něco se nepovedlo')
    {
        $this->error(
            $text,
            timeout: 5000,
            position: 'toast-top toast-end',
            css: 'alert-warning text-white w-96'
        );
    }
}
