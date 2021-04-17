<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GrupoMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('grupomenu')->insert([
            'descripcion' => 'Gestión de Cambio',
            'icono' => 'fas fa-folder',
            'orden' => 1,
        ]);       
        DB::table('grupomenu')->insert([
            'descripcion' => 'Usuarios',
            'icono' => 'fas fa-users',
            'orden' => 3,
        ]); 
      /*   DB::table('grupomenu')->insert([
            'descripcion' => 'Personas',
            'icono' => 'fas fa-user-tie',
            'orden' => 2,
        ]); */
           
           
    }
}
