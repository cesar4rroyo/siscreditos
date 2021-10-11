<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuario')->insert([
            'login' => 'admin',
            'password' => bcrypt('123456'),
            'tipousuario_id' => 1,
        ]);
        DB::table('usuario')->insert([
            'login' => 'marakos',
            'password' => bcrypt('123456'),
            'tipousuario_id' => 2,
            'persona_id' => 1,
        ]);
    }
}
