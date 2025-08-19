<?php

test('roles can be created and retrieved', function () {
    $roleNames = ['customer', 'admin', 'employee'];
    foreach ($roleNames as $name) {
        $role = \App\Models\Roles::create(['role' => $name, 'is_active' => 1]);
        expect($role)->not->toBeNull();
        expect($role->role)->toBe($name);
        expect($role->is_active)->toBe(1);
        $found = \App\Models\Roles::where('role', $name)->first();
        expect($found)->not->toBeNull();
        expect($found->id)->toBe($role->id);
    }
});
