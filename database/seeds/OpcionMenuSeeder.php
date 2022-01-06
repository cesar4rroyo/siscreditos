<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpcionMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //start Grupo Personal
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Persona',
            'icono' => 'fas fa-user-alt',
            'link' => 'persona',
            'orden' => 1,
            'grupomenu_id' => 2
        ]);
        //end Grupo Persona

        //start Gestion        
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Creditos',
            'icono' => 'far fa-file-alt',
            'link' => 'creditos',
            'orden' => 2,
            'grupomenu_id' => 1
        ]);
        //end Gestion

        //start Grupo Usuarios
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Usuario',
            'link' => 'admin/usuario',
            'icono' => 'fas fa-user',
            'orden' => 1,
            'grupomenu_id' => 2
        ]);
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Roles',
            'link' => 'admin/rol',
            'icono' => 'fas fa-users-cog',
            'orden' => 2,
            'grupomenu_id' => 2
        ]);

        DB::table('opcionmenu')->insert([
            'descripcion' => 'Tipos Usuario',
            'icono' => 'fas fa-users-slash',
            'link' => 'admin/tipousuario',
            'orden' => 4,
            'grupomenu_id' => 2
        ]);
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Accesos',
            'link' => 'admin/acceso',
            'icono' => 'fas fa-people-arrows',
            'orden' => 5,
            'grupomenu_id' => 2
        ]);
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Opciones de Menú',
            'icono' => 'fas fa-stream',
            'link' => 'admin/opcionmenu',
            'orden' => 6,
            'grupomenu_id' => 2
        ]);
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Grupos de Menú',
            'icono' => 'fas fa-list-ol',
            'link' => 'admin/grupomenu',
            'orden' => 7,
            'grupomenu_id' => 2
        ]);
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Banco',
            'icono' => 'fas fa-university',
            'link' => 'banco',
            'orden' => 8,
            'grupomenu_id' => 1
        ]);
        //end Grupo Usuarios
        //start Grupo Reportes
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Facturacion-Est.Cuenta',
            'icono' => 'fas fa-chart-area',
            'link' => 'reportecomanda',
            'orden' => 1,
            'grupomenu_id' => 3
        ]);
        DB::table('opcionmenu')->insert([
            'descripcion' => 'Comandas x Área',
            'icono' => 'fas fa-chart-area',
            'link' => 'reportecomandaarea',
            'orden' => 2,
            'grupomenu_id' => 3
        ]);
        //end Grupo Reportes


    }
}
