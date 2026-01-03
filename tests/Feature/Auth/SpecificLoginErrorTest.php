<?php

use App\Models\User;

test('it displays specific error message when email is not found', function () {
    $response = $this->from(route('login'))->post(route('login'), [
        'email' => 'nonexistent@example.com',
        'password' => 'password',
    ]);

    $response->assertRedirect(route('login'));
    $response->assertSessionHasErrors([
        'email' => 'Alamat email tidak terdaftar di sistem kami.',
    ]);
});

test('it displays specific error message when password is wrong', function () {
    $user = User::factory()->create();

    $response = $this->from(route('login'))->post(route('login'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $response->assertRedirect(route('login'));
    $response->assertSessionHasErrors([
        'email' => 'Kata sandi yang Anda masukkan salah. Silakan coba lagi.',
    ]);
});
