<?php

use App\Models\Roles;
use App\Models\User;

test('confirm password screen can be rendered', function () {
    $role = Roles::create(['role' => 'user', 'is_active' => 1]);
    $user = User::factory()->create(['role_id' => $role->id]);

    $response = $this->actingAs($user)->get('/confirm-password');

    $response->assertStatus(200);
});

test('password can be confirmed', function () {
    $role = Roles::create(['role' => 'user', 'is_active' => 1]);
    $user = User::factory()->create(['role_id' => $role->id]);

    $response = $this->actingAs($user)->post('/confirm-password', [
        'password' => 'password',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

test('password is not confirmed with invalid password', function () {
    $role = Roles::create(['role' => 'user', 'is_active' => 1]);
    $user = User::factory()->create(['role_id' => $role->id]);

    $response = $this->actingAs($user)->post('/confirm-password', [
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();
});