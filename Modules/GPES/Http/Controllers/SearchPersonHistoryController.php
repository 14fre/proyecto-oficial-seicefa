<?php

namespace Modules\GPES\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GPES\Entities\ComputerUserAssignment;
use Modules\SICA\Entities\Person;


class SearchPersonHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $assignments  = [];
        return view('gpes::modules.SearchPersonHistory.index', compact("assignments"));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('gpes::create');
    }

  public function Search(Request $request)
{
    $people = Person::with("users")->where("document_number", $request->document_number)->first();

    if (!$people || !isset($people->users[0])) {
        return redirect()
            ->route('gpes.cuentadante.Search.person.index')
            ->with('error', 'No existe un usuario registrado con esa cédula');
    }

    $assignments = ComputerUserAssignment::with("user.person", "computer")
        ->whereHas('user', function ($query) use ($people) {
            $query->where('id', $people->users[0]->id);
        })
        ->get();

    if ($assignments->isEmpty()) {
        return redirect()
            ->route('gpes.cuentadante.Search.person.index')
            ->with('error', 'No se encontraron asignaciones para este usuario');
    }

    

    // Guardar resultados en la sesión si quieres persistirlos, o redirigir con parámetros si aplica
    return redirect()
        ->route('gpes.cuentadante.Search.person.index')
        ->with('assignments', $assignments)
        ->with('success', 'Se encontraron registros relacionados');
}


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('gpes::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('gpes::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
