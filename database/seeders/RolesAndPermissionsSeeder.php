<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions


        Permission::create(['name' => 'users-list','guard_name' => 'admin']);
        Permission::create(['name' => 'users-delete','guard_name' => 'admin']);
        Permission::create(['name' => 'users-create','guard_name' => 'admin']);
        Permission::create(['name' => 'users-edit','guard_name' => 'admin']);



        Permission::create(['name' => 'events-list','guard_name' => 'admin']);
        Permission::create(['name' => 'events-delete','guard_name' => 'admin']);
        Permission::create(['name' => 'events-create','guard_name' => 'admin']);
        Permission::create(['name' => 'events-edit','guard_name' => 'admin']);


        
        Permission::create(['name' => 'games-list','guard_name' => 'admin']);
        Permission::create(['name' => 'games-delete','guard_name' => 'admin']);
        Permission::create(['name' => 'games-create','guard_name' => 'admin']);
        Permission::create(['name' => 'games-edit','guard_name' => 'admin']);



        Permission::create(['name' => 'pages-list','guard_name' => 'admin']);
        Permission::create(['name' => 'pages-delete','guard_name' => 'admin']);
        Permission::create(['name' => 'pages-create','guard_name' => 'admin']);
        Permission::create(['name' => 'pages-edit','guard_name' => 'admin']);






        Permission::create(['name' => 'roles-list','guard_name' => 'admin']);
        Permission::create(['name' => 'roles-delete','guard_name' => 'admin']);
        Permission::create(['name' => 'roles-create','guard_name' => 'admin']);
        Permission::create(['name' => 'roles-edit','guard_name' => 'admin']);


        Permission::create(['name' => 'permissions-list','guard_name' => 'admin']);
        Permission::create(['name' => 'permissions-delete','guard_name' => 'admin']);
        Permission::create(['name' => 'permissions-create','guard_name' => 'admin']);
        Permission::create(['name' => 'permissions-edit','guard_name' => 'admin']);

        




        
        // create roles and assign created permissions

        $role = Role::create(['name' => 'administrator','guard_name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        // // this can be done as separate statements





        $role = Role::create(['name' => 'Medical Rep','guard_name'=>'admin']);
        $role->givePermissionTo('games-list')
        ->givePermissionTo(['events-list'])
        ->givePermissionTo(['events-edit']);


        
        $role = Role::create(['name' => 'Coordinator','guard_name'=>'admin']);
        $role->givePermissionTo('games-list')
        ->givePermissionTo(['events-list'])
        ->givePermissionTo(['events-edit']);



    }
}