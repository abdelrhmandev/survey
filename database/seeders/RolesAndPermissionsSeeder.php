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


        Permission::create(['name' => 'users-list']);
        Permission::create(['name' => 'users-delete']);
        Permission::create(['name' => 'users-create']);
        Permission::create(['name' => 'users-edit']);

 
 

        Permission::create(['name' => 'roles-list']);
        Permission::create(['name' => 'roles-delete']);
        Permission::create(['name' => 'roles-create']);
        Permission::create(['name' => 'roles-edit']);


        Permission::create(['name' => 'permissions-list']);
        Permission::create(['name' => 'permissions-delete']);
        Permission::create(['name' => 'permissions-create']);
        Permission::create(['name' => 'permissions-edit']);

        
        Permission::create(['name' => 'games-list']);
        Permission::create(['name' => 'games-delete']);
        Permission::create(['name' => 'games-create']);
        Permission::create(['name' => 'games-edit']);




        Permission::create(['name' => 'events-list']);
        Permission::create(['name' => 'events-delete']);
        Permission::create(['name' => 'events-create']);
        Permission::create(['name' => 'events-edit']);


        // create roles and assign created permissions

        $role = Role::create(['name' => 'Administrator']);
        $role->givePermissionTo(Permission::all());

        // // this can be done as separate statements

 
 
  
        $role = Role::create(['name' => 'Medical Rep']);
        $role->givePermissionTo('games-list')
        ->givePermissionTo(['games-delete']);



        $role = Role::create(['name' => 'Coordinator']);
        
        $role->givePermissionTo('games-list')
        ->givePermissionTo(['games-create'])   
        ->givePermissionTo(['games-edit']);

 
            


    }
}