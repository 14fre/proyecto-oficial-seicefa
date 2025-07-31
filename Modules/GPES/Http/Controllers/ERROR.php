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
use Modules\SICA\Entities\Person;

class ComputerUserAssignmentController extends Controller
{
  public function index()
    {
        $assignments = ComputerUserAssignment::with(['computer', 'user.person'])
            ->orderBy('assigned_at', 'desc')
            ->get();

        return view('gpes::modules.computeruserassignment.index', compact('assignments'));
    }

    public function create()
    {
        $computers = Computer::where('status', 'disponible')->get();
        return view('gpes::modules.computeruserassignment.create', compact('computers'));
    }

    public function searchUser(Request $request)
    {
        $validated = $request->validate([
            'document_number' => 'required|string|max:255',
        ]);

        $person = Person::with('users')->where('document_number', $validated['document_number'])->first();
        $computers = Computer::where('status', 'disponible')->get();

        if ($person) {
            return view('gpes::modules.computeruserassignment.create', compact('person', 'computers'))
                ->with('success', 'Usuario encontrado, puede asignar un computador.');
        }

        return view('gpes::modules.computeruserassignment.create', compact('computers'))
            ->with('error', 'Usuario no encontrado');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'computer_id' => 'required|exists:computers,id',
            'type' => 'required|in:diario,formacion',
            'assigned_at' => 'required|date',
            'returned_at' => 'nullable|date|after_or_equal:assigned_at',
            'observation' => 'nullable|string',
        ]);

        // Validate returned_at for diario (must be next day)
        if ($validated['type'] === 'diario') {
            $assignedAt = Carbon::parse($validated['assigned_at']);
            $expectedReturnedAt = $assignedAt->copy()->addDay()->format('Y-m-d H:i');
            $providedReturnedAt = null;
            if ($providedReturnedAt !== $expectedReturnedAt) {
                return redirect()->back()->withErrors(['returned_at' => 'Para asignación diaria, la fecha de devolución debe ser el día siguiente.'])->withInput();
            }
        }

        try {
            DB::beginTransaction();

            $assignment = ComputerUserAssignment::create([
                'user_id' => $validated['user_id'],
                'computer_id' => $validated['computer_id'],
                'type' => $validated['type'],
                'assigned_at' => $validated['assigned_at'],
                'returned_at' => $validated['returned_at'],
                'observation' => $validated['observation'],
                'returned' => false,
                'late' => false,
            ]);

            $computer = Computer::find($validated['computer_id']);
            $computer->update([
                'status_day' => $validated['type'] === 'diario' ? 'ocupado' : 'disponible',
                'status' => $validated['type'] === 'formacion' ? 'ocupado' : $computer->status,
            ]);

            DB::commit();

            return redirect()->route('gpes.cuentadante.assignmentsUserComputer.index')
                ->with('success', 'Asignación creada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al crear la asignación: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $assignment = ComputerUserAssignment::with('user.person', 'computer')->findOrFail($id);
        $computers = Computer::where('status', 'disponible')->orWhere('id', $assignment->computer_id)->get();
        $person = $assignment->user->person;

        return view('gpes::modules.computeruserassignment.edit', compact('assignment', 'person', 'computers'));
    }

    public function update(Request $request, $id)
    {
        $assignment = ComputerUserAssignment::findOrFail($id);


     
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'computer_id' => 'required|exists:computers,id',
            'type' => 'required|in:diario,formacion',
            'assigned_at' => 'required|date',
            'returned_at' => 'nullable|date|after_or_equal:assigned_at',
            'observation' => 'nullable|string',
            'returned' => 'boolean',
        ]);

        // Validate returned_at for diario (must be next day)
        if ($validated['type'] === 'diario') {
            $assignedAt = Carbon::parse($validated['assigned_at']);
            $expectedReturnedAt = $assignedAt->copy()->addDay()->format('Y-m-d H:i');
            $providedReturnedAt = $validated['returned_at'] ? Carbon::parse($validated['returned_at'])->format('Y-m-d H:i') : null;
            if ($providedReturnedAt !== $expectedReturnedAt) {
                return redirect()->back()->withErrors(['returned_at' => 'Para asignación diaria, la fecha de devolución debe ser el día siguiente.'])->withInput();
            }
        }

        try {
            DB::beginTransaction();

            // Update computer status if changed
            if ($assignment->computer_id != $validated['computer_id']) {
                $oldComputer = Computer::find($assignment->computer_id);
                if ($oldComputer) {
                    $oldComputer->update([
                        'status_day' => 'disponible',
                        'status' => $assignment->type === 'formacion' ? 'disponible' : $oldComputer->status,
                    ]);
                }
                $newComputer = Computer::find($validated['computer_id']);
                $newComputer->update([
                    'status_day' => $validated['type'] === 'diario' ? 'ocupado' : 'disponible',
                    'status' => $validated['type'] === 'formacion' ? 'ocupado' : ($validated['returned'] ? 'disponible' : $newComputer->status),
                ]);
            } else {
                $computer = Computer::find($validated['computer_id']);
                $computer->update([
                    'status_day' => $validated['type'] === 'diario' ? 'ocupado' : 'disponible',
                    'status' => $validated['type'] === 'formacion' ? 'ocupado' : ($validated['returned'] ? 'disponible' : $computer->status),
                ]);
            }

            $assignment->update([
                'user_id' => $validated['user_id'],
                'computer_id' => $validated['computer_id'],
                'type' => $validated['type'],
                'assigned_at' => $validated['assigned_at'],
                'returned_at' => $validated['returned_at'],
                'observation' => $validated['observation'],
                'returned' => $validated['returned'] ?? false,
                'late' => $validated['returned'] && $validated['returned_at'] && Carbon::now()->gt(Carbon::parse($validated['returned_at'])) ? true : false,
            ]);

            DB::commit();

            return redirect()->route('gpes.cuentadante.assignmentsUserComputer.index')
                ->with('success', 'Asignación actualizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al actualizar la asignación: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $assignment = ComputerUserAssignment::findOrFail($id);
            $computer = Computer::find($assignment->computer_id);

            // Update computer status
            $computer->update([
                'status_day' => 'disponible',
                'status' => $assignment->type === 'formacion' ? 'disponible' : $computer->status,
            ]);

            $assignment->delete();

            DB::commit();

            return redirect()->route('gpes.cuentadante.assignmentsUserComputer.index')
                ->with('success', 'Asignación eliminada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al eliminar la asignación: ' . $e->getMessage());
        }
    }

   public function return($id)
{
    try {
        DB::beginTransaction();

        $assignment = ComputerUserAssignment::findOrFail($id);

        // Evitar marcar como devuelto si ya fue devuelto
        if ($assignment->returned) {
            DB::rollBack();
            return redirect()->route('gpes.cuentadante.assignmentsUserComputer.index')
                ->with('error', 'La asignación ya está marcada como devuelta.');
        }

        $computer = Computer::find($assignment->computer_id);
        $currentTime = Carbon::now();

        // Fecha esperada de devolución (fin del día)
        $expectedReturnTime = $assignment->type === 'diario'
            ? Carbon::parse($assignment->assigned_at)->addDay()->setTime(23, 59, 59)
            : Carbon::parse($assignment->returned_at)->setTime(23, 59, 59);

        // Comparar si se pasó del tiempo
        $isLate = $currentTime->greaterThan($expectedReturnTime);

        // Actualizar la asignación
        $assignment->update([
            'returned' => true,
            'returned_at' => $currentTime,
            'late' => $isLate,
        ]);

        // Liberar el computador
        $computer->update([
            'status_day' => 'disponible',
            'status' => 'disponible',
        ]);

        DB::commit();

        return redirect()->route('gpes.cuentadante.assignmentsUserComputer.index')
            ->with('success', 'Asignación marcada como devuelta exitosamente.' . ($isLate ? ' (Devolución tardía)' : ''));
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Error al marcar la asignación como devuelta: ' . $e->getMessage());
    }
}
 
}
