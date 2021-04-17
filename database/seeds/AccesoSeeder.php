<?php

use App\Models\OpcionMenu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $numero_opcionesmenu = OpcionMenu::count();
        for ($i = 1; $i <= $numero_opcionesmenu; $i++) {
            DB::table('acceso')->insert([
                'tipousuario_id' => 1,
                'opcionmenu_id' => $i,
            ]);
        } 
        
        DB::table('acceso')->insert([
            'tipousuario_id' => 2,
            'opcionmenu_id' => 1,
        ]);
    }
}
