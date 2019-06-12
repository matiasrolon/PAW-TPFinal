<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin =  Role::find(1);
        $role_critic = Role::find(2);
        //admin1
        $user_admin1 = new User();
        $user_admin1->nombre = "Matias Rolon";
        $user_admin1->username = "admin1";
        $user_admin1->email = "matirolon96@gmail.com";
        $user_admin1->password = bcrypt('admin1');
                  //'password' => Hash::make($data['password']) // otra forma de hashear la password
        $user_admin1->biografia = 'Administrador principal de MVJ Reviews';
        $user_admin1->puntos = 10;
        $user_admin1->estado = 'activo';
        $user_admin1->save();
        $user_admin1->roles()->attach($role_admin);
        //admin2
        $user_admin2 = new User();
        $user_admin2->nombre = "Victorio Scafati";
        $user_admin2->username = "admin2";
        $user_admin2->email = "victorioskfati@gmail.com";
        $user_admin2->password = bcrypt('admin2');
        $user_admin2->biografia = 'Administrador principal de MVJ Reviews';
        $user_admin2->puntos = 20;
        $user_admin2->estado = 'activo';
        $user_admin2->save();
        $user_admin2->roles()->attach($role_admin);
        //usuario comun
        $user = new User();
        $user->nombre = "Juan Perez";
        $user->username = "juanperez";
        $user->email = "juanperez@gmail.com";
        $user->password = bcrypt('juanperez');
        $user->biografia = 'Aun no tienes una biografia.';
        $user->puntos = 0;
        $user->estado = 'activo';
        $user->save();
        $user->roles()->attach($role_critic);
    }
}
