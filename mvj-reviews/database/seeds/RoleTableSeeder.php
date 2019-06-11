<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->nombre = "admin";
        $role->descripcion = "Administrador del sitio web";
        $role->save();

        $role = new Role();
        $role->nombre = "critic";
        $role->descripcion = "Critic del sitio web";
        $role->save();

    }
}
