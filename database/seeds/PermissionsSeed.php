<?php

use Illuminate\Database\Seeder;

class PermissionsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('permissions')->insert([
            [
                'name' => "criar_utilizadores",
                'display_name' => "Criar Utilizadores",
                'deletable' => 0,
            ],
            [
                'name' => 'apagar_utilizadores',
                'display_name' => 'Apagar Utilizadores',
                'deletable' => 0,
            ],
            [
                'name' => 'editar_utilizadores',
                'display_name' => 'Editar Utilizadores',
                'deletable' => 0,
            ],
            [
                'name' => 'ver_utilizadores',
                'display_name' => 'Ver Utilizadores',
                'deletable' => 0,
            ],
            [
                'name' => 'criar_cargos',
                'display_name' => 'Criar Cargos',
                'deletable' => 0,
            ],
            [
                'name' => 'apagar_cargos',
                'display_name' => 'Apagar Cargos',
                'deletable' => 0,
            ],
            [
                'name' => 'editar_cargos',
                'display_name' => 'Editar Cargos',
                'deletable' => 0,
            ],
            [
                'name' => 'ver_cargos',
                'display_name' => 'Ver Cargos',
                'deletable' => 0,
            ],
            [
                'name' => 'criar_permissoes',
                'display_name' => 'Criar Permissões',
                'deletable' => 0,
            ],
            [
                'name' => 'apagar_permissoes',
                'display_name' => 'Apagar Permissões',
                'deletable' => 0,
            ],
            [
                'name' => 'editar_permissoes',
                'display_name' => 'Editar Permissões',
                'deletable' => 0,
            ],
            [
                'name' => 'ver_permissoes',
                'display_name' => 'Ver Permissões',
                'deletable' => 0,
            ]

        ]);


        $rolesPermissoes = [
            [
                'role_id' => 1,
                'permission_id' => 1
            ],
            [
                'role_id' => 1,
                'permission_id' => 2
            ],
            [
                'role_id' => 1,
                'permission_id' => 3
            ],
            [
                'role_id' => 1,
                'permission_id' => 4
            ],
            [
                'role_id' => 1,
                'permission_id' => 5
            ],
            [
                'role_id' => 1,
                'permission_id' => 6
            ],
            [
                'role_id' => 1,
                'permission_id' => 7
            ],
            [
                'role_id' => 1,
                'permission_id' => 8
            ],
            [
                'role_id' => 1,
                'permission_id' => 9
            ],
            [
                'role_id' => 1,
                'permission_id' => 10
            ],
            [
                'role_id' => 1,
                'permission_id' => 11
            ],
            [
                'role_id' => 1,
                'permission_id' => 12
            ],


            [
                'role_id' => 2,
                'permission_id' => 1
            ],
            [
                'role_id' => 2,
                'permission_id' => 2
            ],
            [
                'role_id' => 2,
                'permission_id' => 3
            ],
            [
                'role_id' => 2,
                'permission_id' => 4
            ],
            [
                'role_id' => 2,
                'permission_id' => 5
            ],
            [
                'role_id' => 2,
                'permission_id' => 6
            ],
            [
                'role_id' => 2,
                'permission_id' => 7
            ],
            [
                'role_id' => 2,
                'permission_id' => 8
            ],
            [
                'role_id' => 2,
                'permission_id' => 9
            ],
            [
                'role_id' => 2,
                'permission_id' => 10
            ],
            [
                'role_id' => 2,
                'permission_id' => 11
            ],
            [
                'role_id' => 2,
                'permission_id' => 12
            ],
        ];
        DB::table('permission_role')->insert($rolesPermissoes);
    }
}
