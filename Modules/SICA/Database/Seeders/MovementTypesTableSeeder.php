<?php

namespace Modules\SICA\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SICA\Entities\MovementType;

class MovementTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        MovementType::firstOrCreate( // Consulta o registro de tipo de movimiento
            ['name'=>'Baja'],
            ['consecutive'=>0]
        );

        MovementType::firstOrCreate( // Consulta o registro de tipo de movimiento
            ['name'=>'Movimiento Interno'],
            ['consecutive'=>0]
        );

        MovementType::firstOrCreate( // Consulta o registro de tipo de movimiento
            ['name'=>'Venta'],
            ['consecutive'=>0]
        );

        MovementType::firstOrCreate( // Consulta o registro de tipo de movimiento
            ['name'=>'Préstamo Externo'],
            ['consecutive'=>0]
        );

        MovementType::firstOrCreate( // Consulta o registro de tipo de movimiento
            ['name'=>'Préstamo Interno'],
            ['consecutive'=>0]
        );

        // Agregar tipo de movimiento para reporte de daño si no existe
        \Modules\SICA\Entities\MovementType::firstOrCreate([
            'name' => 'Reporte de daño',
        ], [
            'consecutive' => 0 // O el valor que desees
        ]);

    }
}
