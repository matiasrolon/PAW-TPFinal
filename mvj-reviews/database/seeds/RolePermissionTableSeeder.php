<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $role = Role::create(['name' => 'admin']);

      $permission1 = Permission::create(['name' => 'admin films']);
      $permission1->assignRole($role);

      $permission2 = Permission::create(['name' => 'admin newness']);
      $permission2->assignRole($role);

      $role = Role::create(['name' => 'critic']);
    }
}
