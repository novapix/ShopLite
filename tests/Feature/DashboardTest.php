<?php

use App\Models\User;
use App\Models\Roles;

test('guests are redirected to the login page', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

test('authenticated users can visit the dashboard', function () {
    $role = Roles::create(['role' => 'user', 'is_active' => 1]);
    $user = User::factory()->create(['role_id' => $role->id]);
    $this->actingAs($user);

    $this->get('/dashboard')->assertOk() ;

});