<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Role::create(['name' => 'admin']);
        // Role::create(['name' => 'user']);
        // Role::create(['name' => 'moderator']);

        $adminRole = Role::create(['name' => 'admin']);
        $writerRole = Role::create(['name' => 'writer']);

        $permissions = [
            'create post',
            'edit post',
            'delete post',
            'view post',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $adminRole->givePermissionTo(Permission::all());
        $writerRole->givePermissionTo(['create post', 'edit post', 'view post']);
    }
}
