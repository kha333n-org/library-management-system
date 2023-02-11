<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use ReflectionClass;
use Spatie\Permission\Models\Permission;

class Permissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Get all permissions from public static variables of Permissions class as array
        $class = new ReflectionClass(objectOrClass: \App\Utils\Permissions::class);
        $permissions = $class->getStaticProperties();

        foreach ($permissions as $permission) {
            Permission::query()->create(
                [
                    'name' => $permission,
                    'guard_name' => 'sanctum',
                ]
            );
        }
    }
}
