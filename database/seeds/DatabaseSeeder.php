<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTablas([
            'rol',
            'grupomenu',
            'tipousuario',
            'opcionmenu',
            'persona',
            'usuario',
            'acceso',
            'rolpersona',
            'moneda',
        ]);
        $this->call(RolSeeder::class);
        $this->call(GrupoMenuSeeder::class);
        $this->call(TipoUsuarioSeeder::class);
        $this->call(OpcionMenuSeeder::class);
        $this->call(PersonaSeeder::class);
        $this->call(UsuarioSeeder::class);
        $this->call(AccesoSeeder::class);
        $this->call(RolPersonaSeeder::class);
        $this->call(MonedaSeeder::class);
    }
    protected function truncateTablas(array $tablas)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        foreach ($tablas as $tabla) {
            DB::table($tabla)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
