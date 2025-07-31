<?php

namespace Modules\GPES\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\SICA\Entities\App;


use Modules\SICA\Entities\AppProductiveUnit;
use Modules\SICA\Entities\Country;
use Modules\SICA\Entities\Department;
use Modules\SICA\Entities\Farm;
use Modules\SICA\Entities\KindOfPurchase;
use Modules\SICA\Entities\MovementType;
use Modules\SICA\Entities\Municipality;
use Modules\SICA\Entities\Person;
use Modules\SICA\Entities\ProductiveUnit;
use Modules\SICA\Entities\ProductiveUnitWarehouse;
use Modules\SICA\Entities\Sector;
use Modules\SICA\Entities\Warehouse;

class AppTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();


        /* Registro o actualización de la nueva aplicación para Estación de GPES */
        $app = App::updateOrCreate(['name' => 'GPES'], [
            'url' => '/GPES/welcome',
            'color' => '#76250C',
            'icon' => 'fas fa-mug-hot',
            'description' => 'Control de asignaciones de equipos , erramientas de laboratorio bienes y enceres',
            'description_english' => 'Equipment and lab tools assignment control',
        ]);


    

        /* Registro a actualización de sector para la unidad productiva Punto de venta */
        $sector = Sector::updateOrCreate(['name' => 'trasabailidad de bienes'], [
            'description' => 'Sector del centro de formación encargado de la gestión y trasabilidad de equipos, herramientas y bienes del centro',
        ]);

        /* Persona líder de finca y unidad productiva */
        $leader = Person::where('document_number', 1081152142)->first(); // Consulta de datos personales de Lola Fernanda Herrera Hernandez

        /* Obtener ubicación de la finca */
        $country = Country::firstOrCreate([
            'name' => 'Colombia'
        ]);
        $department = Department::firstOrCreate([
            'country_id' => $country->id,
            'name' => 'Huila'
        ]);
        $municipality = Municipality::firstOrCreate([
            'department_id' => $department->id,
            'name' => 'Campoalegre'
        ]);
        $farm = Farm::firstOrCreate(['name'=>'CEFA'],[
            'description'=>'Centro de Formación Agroindustrial La Angostura',
            'area'=>100000,
            'person_id'=>$leader->id,
            'municipality_id'=>$municipality->id,
        ]);

        /* Registro o actualización de la unidad productiva para PTVENTA */
        $productive_unit = ProductiveUnit::updateOrCreate(['name' => 'trasabilidad bienes'], [
            'description' => 'Unidad del centro de formación dedicada a la gestion y trasabilidad de equipos, herramientas y bienes del centro',
            'icon' => 'fas fa-dolly',
            'person_id' => $leader->id,
            'sector_id' => $sector->id,
            'farm_id' => $farm->id
        ]);

        // Asociar a aplicación con unidad productiva
        AppProductiveUnit::firstOrCreate([
            'app_id' => $app->id,
            'productive_unit_id' => $productive_unit->id
        ]);

        /* Registro o actualización de bodega ambiente 1 */
        $warehouse = Warehouse::updateOrCreate(['name' => 'ambiente 1'], [
            'description' => 'bodega encargada de almacenar lo necesario para las formaciones diarias en el centro',
            'app_id' => $app->id
        ]);

            // Asociar a bodega con unidad unidad productiva
        ProductiveUnitWarehouse::firstOrCreate([
            'productive_unit_id' => $productive_unit->id,
            'warehouse_id' => $warehouse->id
        ]);

        
        /* Registro o actualización de bodega ambiente 3 */
        $warehouse = Warehouse::updateOrCreate(['name' => 'ambiente 2'], [
            'description' => 'bodega encargada de almacenar lo necesario para las formaciones diarias en el centro',
            'app_id' => $app->id
        ]);

            // Asociar a bodega con unidad unidad productiva
        ProductiveUnitWarehouse::firstOrCreate([
            'productive_unit_id' => $productive_unit->id,
            'warehouse_id' => $warehouse->id
        ]);

        
        /* Registro o actualización de bodega ambiente 3 */
        $warehouse = Warehouse::updateOrCreate(['name' => 'ambiente 3'], [
            'description' => 'bodega encargada de almacenar lo necesario para las formaciones diarias en el centro',
            'app_id' => $app->id
        ]);

        // Asociar a bodega con unidad unidad productiva
        ProductiveUnitWarehouse::firstOrCreate([
            'productive_unit_id' => $productive_unit->id,
            'warehouse_id' => $warehouse->id
        ]);

        // Verificar o registrar tipo de compra
        KindOfPurchase::firstOrCreate([
            'name' => 'Equipo adquirido',
            'description' => 'Equipo adquirido para uso en el centro de capacitación no se vende',
        ]);

        // Verficar o registrar tipos de movimientos
     
        MovementType::firstOrCreate(['name' => 'Movimiento Interno'],[
            'consecutive' => 0
        ]);

        
        MovementType::firstOrCreate(['name' => 'entrada'],[
            'consecutive' => 0
        ]);

      

   
    }
}
