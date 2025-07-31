<?php

namespace Modules\GPES\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\GPES\Entities\Computer;
use Modules\GPES\Entities\ComputerUserAssignment;
use Modules\GPES\Entities\Notification;
use Modules\SICA\Entities\Person;

class ComputerUserAssignmentDayController extends Controller
{
    // metodo que muestra la pagina inicial de asignaciones de computadores a ausuarios por dia
    // muestra una tabla la cual contiene el listado de las asignaciones que se an echo de tipo diario
    public function index()
    {

        $assignments = ComputerUserAssignment::where("type", "diario")
            ->with(["computer", "user"])
            ->orderBy("created_at", "desc")
            ->get();



        return view('gpes::modules.ComputerUserAssignment.day.index', compact("assignments"));
    }

    // metodo encargado de mostrar el formulario para crear una asignacion, en este fomrulario
    // se muestra los computadores disponibles sin asignar de manera diaria,
    // tambien se esperaque el usuario que este asignando pase la cedula "document_number" de people
    public function create()
    {
        $computers = Computer::where("status_assignment_day", "disponible")->get();
        return view('gpes::modules.ComputerUserAssignment.day.create', compact("computers"));
    }

    //    Metodo encargado de guardar la asignacion de un equipo a un usuario en la tabla assignmentsUserComputer
    // este metodo espera resivir la cedula del usuario "document_number" y el id del computador
    // "computer_id" y la fecha de asignacion "assigned_at" y la ubicacion
    // "location" donde se encuentra el computador asignado
    public function store(Request $request)
    {




        // buscar al usuario atraves de el modelo person en su columna document_numbe
        $peopleUser = Person::with("users")->where("document_number", $request->document_number)->first();

        // preguntar si el usuario exite, en caso de que no se retorna a la vista anterior con une error
        if (!$peopleUser) {
            return back()->with("error", "No se encontro al usuario");
        }


        //obtener el la fecha del dia actual pero tomando la ultima hora del dia
        $endDay = Carbon::now()->endOfDay();


        // hacer un parse de el assignmed_at resivido del fomrulario
        $assigne_at = Carbon::parse($request->assigned_at)->format("Y-m-d H:i:s");




        $assignment = ComputerUserAssignment::create([
            'computer_id' => $request->computer_id,
            'user_id' => $peopleUser->users[0]->id,
            'type' => 'diario',
            'assigned_at' => $assigne_at,
            'returned_at' =>  $endDay, // se alamcena la fecha actual pero a la ultima hora del dia
            'location' => $request->location,
            'observation' => $request->observation,
            "returned" => false, // por defecto el computador no ha sido devuelto
            "late" => false, // por defecto el computador no ha sido devuelto tarde
        ]);

        // Actualizar el estado del computador
        Computer::find($request->computer_id)
            ->update([
                'status_assignment_day' => 'asignado',
            ]);


      


        // genera la notifiacion de la asignacion echa 




        $users_ids = User::with("roles")->whereHas("roles", function ($query) {
            $query->where("slug", "gpes.vigilant");
        })->get();

       
        foreach($users_ids as $user_id){
            Notification::create([
                "user_id" => $user_id->id,
                "responsible_allocation_id" => $assignment->id,
            ]);
        }





        return redirect()->route('gpes.cuentadante.assignmentsUserComputer.day.index')->with('success', 'Asignación creada exitosamente.');
    }


    public function return($id)
    {

        // obtener el registro de la asignacion que vamos a utilizar
        $assignment = ComputerUserAssignment::findOrFail($id);

        // obtener la fecha del dia actual
        $date = Carbon::now();

        // preguntar si la fecha del dia actual es mayor a la fecha en la que se devio de entregar el computador
        if ($date->gt($assignment->returned_at)) {
            // si la fecha actual es mayor a la fecha de entrega, se marca como tarde
            $assignment->update([
                'returned' => true,
                'late' => true, // se marca como tarde
                'returned_at' => $date, // se actualiza la fecha de devolucion
            ]);

            // Actualizar el estado del computador a disponible
            Computer::find($assignment->computer_id)
                ->update([
                    'status_assignment_day' => 'disponible',
                ]);


            return redirect()->route('gpes.cuentadante.assignmentsUserComputer.day.index')->with('success', 'Computador devuelto exitosamente tarde.');
        } else {
            // si la fecha actual es menor a la fecha de entrega, se marca como devuelto

            $assignment->update([
                'returned' => true,
                'late' => false, // no se marca como tarde
                'returned_at' => $date, // se actualiza la fecha de devolucion
            ]);

            // Actualizar el estado del computador a disponible
            Computer::find($assignment->computer_id)
                ->update([
                    'status_assignment_day' => 'disponible',
                ]);

            return redirect()->route('gpes.cuentadante.assignmentsUserComputer.day.index')->with('success', 'Computador devuelto exitosamente a tempo.');
        }
    }

    public function edit($id)
    {
        // Fetch the assignment with related user and computer
        $assignment = ComputerUserAssignment::with(['user.person', 'computer'])->findOrFail($id);

        // Fetch available computers and include the currently assigned computer
        $computers = Computer::where('status_assignment_day', 'disponible')
            ->orWhere('id', $assignment->computer_id)
            ->get();

        return view('gpes::modules.ComputerUserAssignment.day.edit', compact('assignment', 'computers'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'document_number' => 'required|string|max:255',
            'computer_id' => 'required|exists:computers,id',
            'assigned_at' => 'required|date',
            'location' => 'required|string|max:255',
            'observation' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Find the assignment
            $assignment = ComputerUserAssignment::findOrFail($id);

            // Find user by document number
            $person = Person::with('users')->where('document_number', $validated['document_number'])->first();
            if (!$person || !$person->users->count()) {
                return back()->withErrors(['document_number' => 'No se encontró un usuario con esa cédula.'])->withInput();
            }

            // Verify computer availability (unless it's the current computer)
            $computer = Computer::find($validated['computer_id']);
            if ($computer->id !== $assignment->computer_id && $computer->status_assignment_day !== 'disponible') {
                return back()->withErrors(['computer_id' => 'El computador seleccionado no está disponible.'])->withInput();
            }

            // If the computer is changing, update the old computer's status
            if ($assignment->computer_id !== $validated['computer_id']) {
                Computer::find($assignment->computer_id)->update(['status_assignment_day' => 'disponible']);
            }

            // Update the assignment
            $assignment->update([
                'computer_id' => $validated['computer_id'],
                'user_id' => $person->users[0]->id,
                'type' => 'diario',
                'assigned_at' => Carbon::parse($validated['assigned_at'])->format('Y-m-d H:i:s'),
                'location' => $validated['location'],
                'observation' => $validated['observation'],
                'returned_at' => $assignment->returned ? $assignment->returned_at : Carbon::now()->endOfDay(),
            ]);

            // Update the new computer's status
            $computer->update(['status_assignment_day' => 'asignado']);

            DB::commit();

            return redirect()->route('gpes.cuentadante.assignmentsUserComputer.day.index')
                ->with('success', 'Asignación actualizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al actualizar la asignación: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        ComputerUserAssignment::findOrFail($id)->delete();

        return redirect()->route('gpes.cuentadante.assignmentsUserComputer.day.index')->with('success', 'Asignación eliminada exitosamente.');
    }
}
