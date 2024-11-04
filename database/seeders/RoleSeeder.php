<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $client = Role::create(['name' => 'client']);
        $team_lead = Role::create(['name' => 'team_lead']);
        $team_member = Role::create(['name' => 'team_member']);
        $project_manager = Role::create(['name' => 'project_manager']);
        $admin = Role::create(['name' => 'admin']);
        $super_admin = Role::create(['name' => 'super_admin']);

        $permissions = collect(config('permission.permissions'))->keys();

        $permissions_with_guard = collect($permissions->toArray())->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });

        Permission::insert($permissions_with_guard->toArray());

        $super_admin->syncPermissions($permissions);


        $admin->syncPermissions($permissions->filter(
            fn($permission) => !str($permission)->contains(
                [
                    'roles',
                    'permissions',
                ]
            )
        )->toArray());


        $project_manager->syncPermissions($permissions->filter(
            fn($permission) => !str($permission)->contains(
                [
                    'roles',
                    'permissions',
                    'handle',
                ]
            )
        )->toArray());

        $team_member->syncPermissions($permissions->filter(
            fn($permission) => !str($permission)->contains(
                [
                    'roles',
                    'permissions',
                    'handle'
                ]
            )
        )->toArray());

        $team_lead->syncPermissions($permissions->filter(
            fn($permission) => !str($permission)->contains(
                [
                    'roles',
                    'permissions',
                    'handle'
                ]
            )
        )->toArray());

        $client->syncPermissions($permissions->filter(
            fn($permission) => !str($permission)->contains(
                [
                    'roles',
                    'permissions',
                    'handle'
                ]
            )
        )->toArray());
    }
}
