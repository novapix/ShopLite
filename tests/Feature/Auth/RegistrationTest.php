<?php

use App\Models\Roles;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $role = Roles::create(['role' => 'customer', 'is_active' => 1]);
    $response = $this->post('/register', [
        'name' => 'Test User',
        'contact' => '+1234567890',
        'email' => 'test@example.com',
        'address' => '123 Test Street',
        'dob' => '2000-01-01',
    ]);

    $this->assertGuest();
    $response->assertRedirect(route('login'));

    $user = \App\Models\User::where('email', 'test@example.com')->first();
    $customer = \App\Models\Customer::where('email', 'test@example.com')->first();
    expect($user)->not->toBeNull();
    expect($customer)->not->toBeNull();
    expect($customer->user_id)->toBe($user->id);
    expect($user->role_id)->toBe($role->id);
});