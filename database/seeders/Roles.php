<?php

namespace Database\Seeders;

use App\Utils\Globals;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class Roles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Globals::$ROLES as $ROLE) {
            Role::query()->create(
                [
                    'name' => $ROLE,
                    'guard_name' => 'sanctum',
                ]
            );
        }
    }
}
