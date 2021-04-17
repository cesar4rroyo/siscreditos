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
            'password' => bcrypt('admin'),
            'tipousuario_id' => 1,
        ]);
        
    }
}
