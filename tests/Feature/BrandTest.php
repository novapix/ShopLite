<?php

use App\Models\Brand;

test('brands can be created and retrieved', function () {
    $brandNames = ['Apple', 'Samsung', 'Sony'];
    foreach ($brandNames as $name) {
        $brand = Brand::create(['name' => $name]);
        expect($brand)->not->toBeNull();
        expect($brand->name)->toBe($name);
        $found = Brand::where('name', $name)->first();
        expect($found)->not->toBeNull();
        expect($found->id)->toBe($brand->id);
    }
});
