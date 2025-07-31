<?php

namespace Modules\GPES\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GPES\Entities\ComputerUserAssignment;

class SearchComputerHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $assignments  = [];
        return view('gpes::modules.SearchComputerHistory.index',compact("assignments"));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
  public function Search(Request $request)
{
    $request->validate([
        'serial_number' => 'required|string',
    ]);

    $assignments = ComputerUserAssignment::with('user', 'computer')
        ->whereHas('computer', function ($query) use ($request) {
            $query->where('serial_number', $request->serial_number);
        })
        ->get();

    if ($assignments->isEmpty()) {
        return view('gpes::modules.SearchComputerHistory.index', compact('assignments'))
            ->with('error', 'No se encontró ningún resultado relacionado con ese número de serie');
    }

    return view('gpes::modules.SearchComputerHistory.index', compact('assignments'))
        ->with('success', 'Se encontraron registros relacionados');
}




    public function create()
    {
        return view('gpes::create');

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
