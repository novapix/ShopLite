<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['role' => 'superadmin', 'is_active' => true],
            ['role' => 'admin', 'is_active' => true],
            ['role' => 'employee', 'is_active' => true],
            ['role' => 'customer', 'is_active' => true],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert([
                'role' => $role['role'],
                'is_active' => $role['is_active'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
