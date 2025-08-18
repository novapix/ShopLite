<?php

use App\Models\User;
use App\Models\Roles;

test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $role = Roles::create(['role' => 'admin', 'is_active' => 1]);
    $user = User::factory()->create(['role_id' => $role->id]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('admin.dashboard', absolute: false));
});

test('users can authenticate using the login screen as regular user', function () {
    $role = Roles::create(['role' => 'user', 'is_active' => 1]);
    $user = User::factory()->create(['role_id' => $role->id]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));
});

test('users can not authenticate with invalid password', function () {
    $role = Roles::create(['role' => 'admin', 'is_active' => 1]);
    $user = User::factory()->create(['role_id' => $role->id]);

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $role = Roles::create(['role' => 'admin', 'is_active' => 1]);
    $user = User::factory()->create(['role_id' => $role->id]);

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/');
});