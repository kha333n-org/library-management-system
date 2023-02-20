<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::findById(1, 'sanctum');

        $user = User::query()->create(
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'address' => 'Lahore',
                'phone_number' => '03401234567',
                'is_active' => true,
                'password' => Hash::make('123456'),
            ]
        );

        $user->assignRole($role);
    }
}
