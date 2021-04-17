<?php

use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonedaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('moneda')->insert([
            'nombre' => 'Dolar Americano',
            'codigo'=>'USD',
            'descripcion' => 'lorem ipsum',
            'preciocompra' => 3.6246,
            'precioventa' => 3.6296,
        ]); 
        DB::table('moneda')->insert([
            'nombre' => 'Euro',
            'codigo'=>'EUR',
            'Descripcion' => 'lorem ipsum',
            'preciocompra' => 4.3534,
            'precioventa' => 4.3568,
        ]);  
        DB::table('moneda')->insert([
            'nombre' => 'Dolar Australiano',
            'codigo'=>'AUD',
            'descripcion' => 'lorem ipsum',
            'preciocompra' =>  2.8116,
            'precioventa' =>  2.8136,
        ]);  
        DB::table('moneda')->insert([
            'nombre' => 'Peso Chileno',
            'codigo'=>'CLP',
            'descripcion' => 'lorem ipsum',
            'preciocompra' => 0.0052,
            'precioventa' => 0.0054,
        ]);  
        DB::table('moneda')->insert([
            'nombre' => 'Peso Colombiano',
            'codigo'=>'COP',
            'Descripcion' => 'lorem ipsum',
            'preciocompra' => 0.0010,
            'precioventa' => 0.0011,
        ]);  
        DB::table('moneda')->insert([
            'nombre' => 'Dolar Canadiense',
            'codigo'=>'CAD',
            'descripcion' => 'lorem ipsum',
            'preciocompra' => 2.9055,
            'precioventa' => 2.9069,
        ]);  
        DB::table('moneda')->insert([
            'nombre' => 'Libra Esterlina',
            'codigo'=>'GBP',
            'Descripcion' => 'lorem ipsum',
            'preciocompra' => 5.0319,
            'precioventa' => 5.0329,
        ]);  
          
        DB::table('moneda')->insert([
            'nombre' => 'Yen',
            'codigo'=>'JPY',
            'Descripcion' => 'lorem ipsum',
            'preciocompra' => 0.0333,
            'precioventa' => 0.03334,
        ]);  
        
    }
}
