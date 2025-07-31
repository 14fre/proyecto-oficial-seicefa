<?php

namespace Modules\GPES\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\GPES\Entities\Computer;
use Modules\SICA\Entities\Element;
use Modules\SICA\Entities\Category;
use Modules\SICA\Entities\KindOfPurchase;
use Modules\SICA\Entities\MeasurementUnit;



use Modules\SICA\Entities\Inventory;
use Modules\SICA\Entities\ProductiveUnit;
use Modules\SICA\Entities\ProductiveUnitWarehouse;
use Modules\SICA\Entities\Movement;

use Modules\SICA\Entities\MovementDetail;
use Modules\SICA\Entities\MovementResponsibility;
use Modules\SICA\Entities\MovementType;
use Modules\SICA\Entities\WarehouseMovement;

class ElementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $elements = Element::with(['category', 'measurement_unit', 'Computers'])
            ->whereHas('category', function ($query) {
                $query->where('name', 'Computers');
            })
            ->orderBy('name', 'ASC')
            ->get();

          

        return view('gpes::modules.computers.index', compact('elements'));
    }

    public function create()
    {


        // Obtener la unidad productiva "Trazabilidad de Bienes"
        $productiveUnit = ProductiveUnit::where('name', 'trasabilidad bienes')->firstOrFail();

        // Obtener bodegas asociadas a la unidad productiva
        $warehouses = $productiveUnit->productive_unit_warehouses->map(function ($puw) {
            return [
                'id' => $puw->warehouse->id,
                'name' => $puw->warehouse->name,
                'pivot_id' => $puw->id,
            ];
        });


        // Obtener categoría, unidad de medida y tipo de compra
        $category = Category::where('name', 'Computers')->firstOrFail();

        $measurement_units = MeasurementUnit::where('name', 'Unidad')->firstOrFail();
        $kind_of_purchases = KindOfPurchase::where('name', 'Equipo adquirido')->firstOrFail();


        return view('gpes::modules.computers.create', compact('category', 'measurement_units', 'kind_of_purchases', 'warehouses'));
    }

    public function store(Request $request)
    {


        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'measurement_unit_id' => 'required|exists:measurement_units,id',
            'kind_of_purchase_id' => 'required|exists:kind_of_purchases,id',
            'category_id' => 'required|exists:categories,id',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'serial_number' => 'required|string|max:255|unique:computers,serial_number',
            'model' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'processor' => 'nullable|string|max:255',
            'ram' => 'nullable|string|max:255',
            'operating_system' => 'nullable|string|max:255',
            'warehouse_id' => 'required|exists:productive_unit_warehouses,id',
        ]);

        // Contar computadores para generar nombre dinámico
      
        $numberComputer = null;
        while(True){
            $numberComputer = Element::whereHas('category', function ($query) {
                $query->where('name', 'Computers');
            })->count() + mt_rand(10000000, 99999999);

            if(! Element::where("name", "computer ". $numberComputer)->first() ){
                break;
            }
        }

        try {
            DB::beginTransaction();

            // Crear elemento
            $element = Element::create([
                'name' => 'Computer ' . $numberComputer,
                'measurement_unit_id' => $validated['measurement_unit_id'],
                'kind_of_purchase_id' => $validated['kind_of_purchase_id'],
                'category_id' => $validated['category_id'],
                'price' => $validated['price'],
                'description' => $validated['description'],
                'slug' => Str::slug('Computer ' . $numberComputer),
            ]);

            // Crear computador
            $computer = Computer::create([
                'name' => $validated['name'],
                'element_id' => $element->id,
                'serial_number' => $validated['serial_number'],
                'model' => $validated['model'],
                'brand' => $validated['brand'],
                'processor' => $validated['processor'],
                'ram' => $validated['ram'],
                'operating_system' => $validated['operating_system'],
            ]);

            // Crear registro de inventario
            $inventory = Inventory::create([
                'productive_unit_warehouse_id' => $validated['warehouse_id'],
                'element_id' => $element->id,
                'amount' => 1, // Un computador por número de serie
                'destination' => 'Formación', // Típico para computadores en un centro de formación
                'state' => 'Disponible',
                'lot_number' =>  $element->id,
                'person_id' => Auth::user()->person_id,
                'description' => $validated['description'],
                'price' => $validated['price'] ?? 0,
                'mark' => $validated['brand'] ?? 'Desconocido',
                'inventory_code' => mt_rand(10000000, 99999999),
                'production_date' => now(), // Fecha actual como producción
                'expiration_date' => null, // No aplica para computadores
                'stock' => 1, // Inicialmente 1 computador  
            ]);

            // Registrar movimiento de entrada (opcional, para trazabilidad)
            $movementType = MovementType::where('name', 'entrada')->firstOrFail();
            $current_datetime = now()->milliseconds(0);

            $movement = Movement::create([
                'registration_date' => $current_datetime,
                'movement_type_id' => $movementType->id,
                'voucher_number' => 0,
                'state' => 'Aprobado',
                'price' => $validated['price'] ?? 0,
            ]);

            MovementDetail::create([
                'movement_id' => $movement->id,
                'inventory_id' => $inventory->id,
                'amount' => 1,
                'price' => $validated['price'] ?? 0,
            ]);

            MovementResponsibility::create([
                'person_id' => Auth::user()->person_id,
                'movement_id' => $movement->id,
                'role' => 'AUTORIZA',
                'date' => $current_datetime,
            ]);

            WarehouseMovement::create([
                'productive_unit_warehouse_id' => $validated['warehouse_id'],
                'movement_id' => $movement->id,
                'role' => 'Recibe',
            ]);

            $movementType->update(['consecutive' => $movementType->consecutive + 1]);
            $movement->update(['voucher_number' => $movementType->consecutive]);

            DB::commit();

            return redirect()->route('gpes.cuentadante.computers.index')
                ->with('success', 'Computador creado y asignado a la bodega exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al crear el computador: ' . $e->getMessage());
        }
    }

  public function edit($id)
    {
        // Obtener el elemento por ID
        $element = Element::with('computers', 'inventories')->findOrFail($id);

        // Obtener la unidad productiva "Trazabilidad de Bienes"
        $productiveUnit = ProductiveUnit::where('name', 'trasabilidad bienes')->firstOrFail();

        // Obtener bodegas asociadas a la unidad productiva
        $warehouses = $productiveUnit->productive_unit_warehouses->map(function ($puw) {
            return [
                'id' => $puw->warehouse->id,
                'name' => $puw->warehouse->name,
                'pivot_id' => $puw->id,
            ];
        });

        // Obtener categoría, unidad de medida y tipo de compra
        $category = Category::where('name', 'Computers')->firstOrFail();
        $measurement_units = MeasurementUnit::where('name', 'Unidad')->firstOrFail();
        $kind_of_purchases = KindOfPurchase::where('name', 'Equipo adquirido')->firstOrFail();



        return view('gpes::modules.computers.edit', compact('element', 'category', 'measurement_units', 'kind_of_purchases', 'warehouses'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'measurement_unit_id' => 'required|exists:measurement_units,id',
            'kind_of_purchase_id' => 'required|exists:kind_of_purchases,id',
            'category_id' => 'required|exists:categories,id',
            'price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'serial_number' => 'required|string|max:255|unique:computers,serial_number,' . $id . ',element_id',
            'model' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'processor' => 'nullable|string|max:255',
            'ram' => 'nullable|string|max:255',
            'operating_system' => 'nullable|string|max:255',
            'warehouse_id' => 'required|exists:productive_unit_warehouses,id',
        ]);

        try {
            DB::beginTransaction();

            // Obtener el elemento y el computador asociado
            $element = Element::with('computers', 'inventories')->findOrFail($id);
            $computer = $element->computers;
            $inventory = $element->inventories;

         
            // Actualizar el elemento
            $element->update([
                'measurement_unit_id' => $validated['measurement_unit_id'],
                'kind_of_purchase_id' => $validated['kind_of_purchase_id'],
                'category_id' => $validated['category_id'],
                'price' => $validated['price'],
                'description' => $validated['description'],
                'slug' => Str::slug($element->name),
            ]);

       

            // Actualizar el computador
            $computer->update([
                'name' => $validated['name'],
                'serial_number' => $validated['serial_number'],
                'model' => $validated['model'],
                'brand' => $validated['brand'],
                'processor' => $validated['processor'],
                'ram' => $validated['ram'],
                'operating_system' => $validated['operating_system'],
            ]);


            //  // Crear registro de inventario
            // $inventory = Inventory::create([
            //     'productive_unit_warehouse_id' => $validated['warehouse_id'],
            //     'element_id' => $element->id,
            //     'amount' => 1, // Un computador por número de serie
            //     'destination' => 'Formación', // Típico para computadores en un centro de formación
            //     'state' => 'Disponible',
            //     'lot_number' =>  $element->id,
            //     'person_id' => Auth::user()->person_id,
            //     'description' => $validated['description'],
            //     'price' => $validated['price'] ?? 0,
            //     'mark' => $validated['brand'] ?? 'Desconocido',
            //     'inventory_code' => mt_rand(10000000, 99999999),
            //     'production_date' => now(), // Fecha actual como producción
            //     'expiration_date' => null, // No aplica para computadores
            //     'stock' => 1, // Inicialmente 1 computador  
            // ]);
           
            // Actualizar el inventario


            $inventory = Inventory::where('element_id', $element->id)->firstOrFail();
          
            $inventory->update([
                'productive_unit_warehouse_id' => $validated['warehouse_id'],
                'price' => $validated['price'] ?? 0,
                'description' => $validated['description'],
                'mark' => $validated['brand'] ?? 'Desconocido',
            ]);


            
            // Registrar movimiento de actualización (opcional, para trazabilidad)
            $movementType = MovementType::where('name', 'Movimiento Interno')->first();

            

            $current_datetime = now()->milliseconds(0);

            $movement = Movement::create([
                'registration_date' => $current_datetime,
                'movement_type_id' => $movementType->id,
                'voucher_number' => 0,
                'state' => 'Aprobado',
                'price' => $validated['price'] ?? 0,
            ]);

            MovementDetail::create([
                'movement_id' => $movement->id,
                'inventory_id' => $inventory->id,
                'amount' => 1,
                'price' => $validated['price'] ?? 0,
            ]);

            MovementResponsibility::create([
                'person_id' => Auth::user()->person_id,
                'movement_id' => $movement->id,
                'role' => 'AUTORIZA',
                'date' => $current_datetime,
            ]);

            WarehouseMovement::create([
                'productive_unit_warehouse_id' => $validated['warehouse_id'],
                'movement_id' => $movement->id,
                'role' => 'Recibe',
            ]);

            $movementType->update(['consecutive' => $movementType->consecutive + 1]);
            $movement->update(['voucher_number' => $movementType->consecutive]);

   
            DB::commit();

            return redirect()->route('gpes.cuentadante.computers.index')
                ->with('success', 'Computador actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al actualizar el computador: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $element = Element::findOrFail($id);
        $element->delete();

        return redirect()->route('gpes.cuentadante.computers.index')
            ->with('success', 'Computador eliminado exitosamente.');
    }
}
