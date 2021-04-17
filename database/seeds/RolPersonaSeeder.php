<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolPersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rolpersona')->insert([  
            'persona_id'=>1,
            'rol_id'=>1
        ]);
        DB::table('rolpersona')->insert([  
            'persona_id'=>1,
            'rol_id'=>2
        ]);
    }
}
