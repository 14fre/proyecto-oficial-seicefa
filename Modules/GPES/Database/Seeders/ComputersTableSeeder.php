<?php

namespace Modules\GPES\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\GPES\Entities\Computer;
use Modules\SICA\Entities\Category;
use Modules\SICA\Entities\Element;
use Modules\SICA\Entities\KindOfPurchase;
use Modules\SICA\Entities\MeasurementUnit;
use Illuminate\Support\Str;
use Modules\SICA\Entities\App;
use Modules\SICA\Entities\Inventory;
use Modules\SICA\Entities\Movement;
use Modules\SICA\Entities\MovementDetail;
use Modules\SICA\Entities\MovementResponsibility;
use Modules\SICA\Entities\MovementType;
use Modules\SICA\Entities\Person;
use Modules\SICA\Entities\ProductiveUnit;
use Modules\SICA\Entities\ProductiveUnitWarehouse;
use Modules\SICA\Entities\Warehouse;
use Modules\SICA\Entities\WarehouseMovement;

class ComputersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

         // Buscar el registro de categorias que tengan como nombre computers
        $category = Category::updateOrCreate(['name' => 'Computers'] , [
          
            'kind_of_property' => 'Devolutivo',
        ]);

        // buscamos el registro con el tipo de compra que tenga el nombre equipo adquirido
        $kind_of_purchase = KindOfPurchase::where("name", "Equipo adquirido")->first() ;

        // buscar el registro de la unidad de medida que tenga como abreviación Ud
        $measurement_unit = MeasurementUnit::where('abbreviation' , 'Ud')->first();

        // buscar el registro de tipo de movimiento que tenga como nombre entrada
        $movement_type = MovementType::where('name' , 'entrada')->first();

        // buscar el registro de la persona que tenga como número de documento 1081152142
        $person = Person::where("document_number", 1081152142)->first();

        // buscar el registro de la bodega que tenga como nombre ambiente 2
        $warehouse = Warehouse::where('name' , 'ambiente 2')->first();

        // buscar el registro de la unidad productiva que tenga como nombre trasabilidad bienes
        $productive_unit = ProductiveUnit::where('name' , 'trasabilidad bienes')->first();


        $productiveUnitwarehouse = ProductiveUnitWarehouse::where('productive_unit_id' , $productive_unit->id)
        ->where('warehouse_id' , $warehouse->id)->first();



        // crear un elemento, crea un computador, le asigna el id del elemento al computador, asigan un elemento a una bodega atraves de inventories
        DB::transaction(function () use ($category, $kind_of_purchase, $measurement_unit, $movement_type, $person, $productiveUnitwarehouse) {
            // Define sample computers
            $computers = [
                [
                    'computer' => [
                        'name' => 'Dell XPS 13',
                        'serial_number' => 'XPS13-001',
                        'model' => 'XPS 13',
                        'brand' => 'Dell',
                        'processor' => 'Intel i7',
                        'ram' => '16GB',
                        'operating_system' => 'Windows 11',
                        'description' => 'High-performance laptop for training',
                        'price' => 1200000,
                        'image' => null, // Optional: set to a path like 'computers/dell_xps.jpg' if needed
                    ],
                ],
                [
                    'computer' => [
                        'name' => 'HP Pavilion 15',
                        'serial_number' => 'HP15-002',
                        'model' => 'Pavilion 15',
                        'brand' => 'HP',
                        'processor' => 'Intel i5',
                        'ram' => '8GB',
                        'operating_system' => 'Windows 10',
                        'description' => 'Mid-range laptop for classroom use',
                        'price' => 800000,
                        'image' => null,
                    ],
                ],
                
            ];

            foreach ($computers as $index => $computerData) {

                // cuenta cunatos elementos con la categoria computers hay en la tabla elements
                $countComputer = Element::whereHas('category', function ($query) {
                    $query->where('name', 'Computers');
                })->count() + 1;

                // crear une elmento en la tabal elements 
                $element = Element::create([
                    'name' => 'Computer ' . $countComputer,
                    'measurement_unit_id' => $measurement_unit->id,
                    'kind_of_purchase_id' => $kind_of_purchase->id,
                    'category_id' => $category->id,
                    'price' => $computerData['computer']['price'],
                    'description' => $computerData['computer']['description'],
                    'slug' => Str::slug('Computer ' . $countComputer),
                ]);
        

                // Create Computer
                $computer = Computer::create([
                    'name' => $computerData['computer']['name'],
                    'element_id' => $element->id,
                    'serial_number' => $computerData['computer']['serial_number'],
                    'model' => $computerData['computer']['model'],
                    'brand' => $computerData['computer']['brand'],
                    'processor' => $computerData['computer']['processor'],
                    'ram' => $computerData['computer']['ram'],
                    'operating_system' => $computerData['computer']['operating_system'],
                   
                    
                ]);

                // Create Inventory
                $inventory = Inventory::create([
                    'productive_unit_warehouse_id' => $productiveUnitwarehouse->id,
                    'element_id' => $element->id,
                    'amount' => 1,
                    'destination' => 'Formación',
                    'state' => 'Disponible',
                    'lot_number' => $element->id,
                    'person_id' => $person->id,
                    'description' => $computerData['computer']['description'],
                    'price' => $computerData['computer']['price'] ?? 0,
                    'mark' => $computerData['computer']['brand'] ?? 'Desconocido',
                    'inventory_code' => mt_rand(10000000, 99999999),
                    'production_date' => now(),
                    'expiration_date' => null,
                    'stock' => 1,
                ]);

                // Create Movement
                $current_datetime = now()->milliseconds(0);
                $movement = Movement::create([
                    'registration_date' => $current_datetime,
                    'movement_type_id' => $movement_type->id,
                    'voucher_number' => 0,
                    'state' => 'Aprobado',
                    'price' => $computerData['computer']['price'] ?? 0,
                ]);

                // Create MovementDetail
                MovementDetail::create([
                    'movement_id' => $movement->id,
                    'inventory_id' => $inventory->id,
                    'amount' => 1,
                    'price' => $computerData['computer']['price'] ?? 0,
                ]);

                // Create MovementResponsibility
                MovementResponsibility::create([
                    'person_id' => $person->id,
                    'movement_id' => $movement->id,
                    'role' => 'AUTORIZA',
                    'date' => $current_datetime,
                ]);

                // Create WarehouseMovement
                WarehouseMovement::create([
                    'productive_unit_warehouse_id' => $productiveUnitwarehouse->id,
                    'movement_id' => $movement->id,
                    'role' => 'Recibe',
                ]);

                // Update movement type consecutive and voucher number
                $movement_type->update(['consecutive' => $movement_type->consecutive + 1]);
                $movement->update(['voucher_number' => $movement_type->consecutive]);
            }
        });
    }
}
