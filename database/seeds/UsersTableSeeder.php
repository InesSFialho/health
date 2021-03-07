<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = array(
            [
                'id' => 1,
                'name' => 'Vítor Silva',
                'email' => 'vitormmsilva@gmail.com',
                'password' => Hash::make('utilizador123'),
                'is_active' => true,
            ],
            [
                'id' => 2,
                'name' => 'Bruno Costa',
                'email' => 'brunoxdcosta@gmail.com',
                'password' => Hash::make('utilizador123'),
                'is_active' => true,
            ],
            [
                'id' => 3,
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'password' => Hash::make('utilizador123'),
                'is_active' => true,
            ],
            [
                'id' => 4,
                'name' => 'Moderador',
                'email' => 'mod@mail.com',
                'password' => Hash::make('utilizador123'),
                'is_active' => true,
            ],
            [
                'id' => 5,
                'name' => 'User',
                'email' => 'user@mail.com',
                'password' => Hash::make('utilizador123'),
                'is_active' => true,
            ]
        );

        $roles = array(
            [
                'id' => 1,
                'name' => 'administrator',
                'display_name' => 'Administrador',
                'description' => 'Administrador.'
            ],
            [
                'id' => 2,
                'name' => 'moderator',
                'display_name' => 'Moderador',
                'description' => 'Moderador.'
            ],
            [
                'id' => 3,
                'name' => 'user',
                'display_name' => 'Utilizador',
                'description' => 'Utilizador.'
            ]
        );


        $role_user = array(
            [
                'role_id' => '1',
                'user_id' => '1',
                'user_type' => 'App\User'
            ],
            [
                'role_id' => '1',
                'user_id' => '2',
                'user_type' => 'App\User'
            ],
            [
                'role_id' => '1',
                'user_id' => '3',
                'user_type' => 'App\User'
            ],
            [
                'role_id' => '2',
                'user_id' => '4',
                'user_type' => 'App\User'
            ],
            [
                'role_id' => '3',
                'user_id' => '5',
                'user_type' => 'App\User'
            ]
        );
       

        DB::table('users')->insert($users);

        DB::table('roles')->insert($roles);

        DB::table('role_user')->insert($role_user);
    }
}
