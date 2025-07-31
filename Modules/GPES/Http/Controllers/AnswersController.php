<?php

namespace Modules\GPES\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GPES\Entities\report;
class AnswersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

 
         $reports = Report::with("computer","involved","accused","responsible_allocation")->where("status_reports","!=","resolved")->get();
       
        return view('gpes::modules.answers.index',compact("reports"));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
  public function create($id)
{
    // Validar que $id sea un entero
    if (!is_numeric($id) || $id <= 0) {
        return redirect()->back()->with('error', 'ID de reporte inválido');
    }

    // Obtener el reporte con sus relaciones en una sola consulta
    $reportRespons = Report::with(['computer', 'involved', 'accused', 'responsible_allocation.user'])
        ->where('id', $id)
        ->first();

    // Verificar si el reporte existe
    if (!$reportRespons) {
        return redirect()->back()->with('error', 'Reporte no encontrado');
    }

    // Actualizar el estado del reporte
    $reportRespons->update([
        'status_reports' => 'in_progress'
    ]);

  
    return view('gpes::modules.answers.create', compact('reportRespons'));
}

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $report = Report::where("id",$request->report_id)->first();

      
        $report->update([
            "answer" => $request->answer,
            "status_reports" => "resolved",
        ]
        );

        return redirect()->route("gpes.cuentadante.answers.index")->with("success","Respuesta envianda con exito al reporte");
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
