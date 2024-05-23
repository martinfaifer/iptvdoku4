<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\ForgottenPasswordComponent;

it('return login page', function () {
    $this->get('login')->assertSeeLivewire(Login::class);
});

it('return forgotten password page', function () {
    $this->get('forgotten-password')->assertSeeLivewire(ForgottenPasswordComponent::class);
});
