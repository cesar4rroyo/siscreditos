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
            'nombres' => 'Santiago Ronald',
            'apellidopaterno' => 'Rodas',
            'apellidomaterno' => 'Ipanaque',
            'dni' => '45841576',
            'telefono' => '974866028',
            
        ]);
        DB::table('persona')->insert([
            'nombres' => 'Richard',
            'apellidopaterno' => 'Serrano',
            'apellidomaterno' => 'Bautista',
            'dni' => '75020436',
            'telefono' => '986783159',

        ]);
        DB::table('persona')->insert([
            'nombres' => 'Juan Eduardo',
            'apellidopaterno' => 'Bazan',
            'apellidomaterno' => 'Guerrero',
            'dni' => '45841576',
            'telefono' => '932827302',
        ]);
        DB::table('persona')->insert([
            'nombres' => 'César',
            'apellidopaterno' => 'Arroyo',
            'apellidomaterno' => 'Torres',
            'dni' => '71482136',
            'telefono' => '924734626',
        ]);
    }
}
