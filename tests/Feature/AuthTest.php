<?php

use App\Models\User;
use Livewire\Livewire;
use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendForgottenPasswordMail;
use App\Livewire\Auth\ForgottenPasswordComponent;

it('return login page', function () {
    $this->get('login')->assertSeeLivewire(Login::class);
});

it('return forgotten password page', function () {
    $this->get('forgotten-password')->assertSeeLivewire(ForgottenPasswordComponent::class);
});

it('allows users to login with valid credentials', function () {
    // Create a user for testing
    $user = User::factory()->create([
        'email' => 'user@example.com',
        'password' => bcrypt('password'),
    ]);

    Livewire::test(Login::class)
        ->set('email', 'user@example.com')
        ->set('password', 'password')
        ->call('login')
        ->assertStatus(200);

    // Ensure the user is authenticated
    $this->actingAs($user);

    $user->delete();
});

it('does not allow users to login with excessively long email', function () {
    Livewire::test(Login::class)
        ->set('email', str_repeat('a', 256) . '@example.com')
        ->set('password', 'password')
        ->call('login')
        ->assertHasErrors('email');
});

it('does not allow users to login with excessively long password', function () {
    Livewire::test(Login::class)
        ->set('email', 'user@example.com')
        ->set('password', str_repeat('a', 256))
        ->call('login')
        ->assertHasErrors(['password' => 'max:255']);
});

it('does not allow users to login with empty email', function () {
    Livewire::test(Login::class)
        ->set('email', '')
        ->set('password', 'password')
        ->call('login')
        ->assertHasErrors(['email' => 'required']);
});

it('does not allow users to login with empty password', function () {
    Livewire::test(Login::class)
        ->set('email', 'user@example.com')
        ->set('password', '')
        ->call('login')
        ->assertHasErrors(['password' => 'required']);
});
