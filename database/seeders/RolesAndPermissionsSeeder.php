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

  
        // create roles and assign created permissions

        $role = Role::create(['name' => 'Administrator']);
        $role->givePermissionTo(Permission::all());  
        $role = Role::create(['name' => 'Medical Rep']);
  
        $role = Role::create(['name' => 'Coordinator']);
 

 
            


    }
}