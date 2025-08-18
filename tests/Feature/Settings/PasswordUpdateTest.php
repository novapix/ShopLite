<?php

use App\Models\User;
use App\Models\Roles;
use Illuminate\Support\Facades\Hash;

test('password can be updated', function () {
    $role = Roles::create(['role' => 'user', 'is_active' => 1]);
    $user = User::factory()->create(['role_id' => $role->id]);

    $response = $this
        ->actingAs($user)
        ->from('/settings/password')
        ->put('/settings/password', [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/settings/password');

    expect(Hash::check('new-password', $user->refresh()->password))->toBeTrue();
});

test('correct password must be provided to update password', function () {
    $role = Roles::create(['role' => 'user', 'is_active' => 1]);
    $user = User::factory()->create(['role_id' => $role->id]);

    $response = $this
        ->actingAs($user)
        ->from('/settings/password')
        ->put('/settings/password', [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response
        ->assertSessionHasErrors('current_password')
        ->assertRedirect('/settings/password');
});