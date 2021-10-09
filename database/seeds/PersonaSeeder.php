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
            'nombres' => 'César',
            'apellidopaterno' => 'Arroyo',
            'apellidomaterno' => 'Torres',
            'dni' => '71482136',
            'telefono' => '924734626',
        ]);
    }
}
