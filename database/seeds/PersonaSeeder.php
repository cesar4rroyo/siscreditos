<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('persona')->insert([
            'nombres' => 'Operador',
            'apellidopaterno' => 'Marakos',
            'apellidomaterno' => 'Creditos',
            'dni' => '88888888',
            'telefono' => '999999999',
        ]);
    }
}
