<?php

namespace Modules\GPES\Http\Controllers;

use Carbon\Carbon;
use Faker\Provider\ar_EG\Company;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\GPES\Entities\Computer;
use Modules\GPES\Entities\ComputerUserAssignment;
use Modules\SICA\Entities\Person;
use Modules\GPES\Entities\report;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $reports = Report::with("computer","involved","accused","responsible_allocation")->where("involved_id",auth()->id())->get();
       
        return view('gpes::modules.reports.index',compact("reports"));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
      

        return view('gpes::modules.reports.create');
    }


//   $table->id();
//             $table->string('title');
//             $table->text('description')->nullable();
//             $table->text('answer')->nullable();
//             $table->enum('status_reports',["pending","in_progress","resolved",])->default('pending'); // pending, in_progress, resolved
//             $table->foreignId('computer_id')->constrained('computers')->onDelete('cascade'); // computador involucrado
//             $table->foreignId('involved_id')->constrained('users')->onDelete('cascade'); // la persona que hizo el reporte
//             $table->foreignId("accused")->constrained('users')->onDelete('cascade')->nullable(); // la persona acusada, puede ser null si no hay acusados
//             $table->foreignId("responsible_allocation")->constrained('computer_user_assignments')->onDelete('cascade')->nullable(); // la persona responsable del computador, puede ser null si no hay responsable
//             $table->dateTime('reported_at')->nullable();
//             $table->dateTime('resolved_at')->nullabl@extends('gpes::layouts.master')
 
    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        // ( 1 )
        // id del usuario que esta haciendo el reporte
        $involved = auth()->id();
        // ( 2 )
        // estado en el que se guardara el reporte 
        $status_report = "pending";
        // ( 3 )
        // obtener el objeto del computador relacionado atraves de sus cerial
        $computer = Computer::where("serial_number",$request->serial_number)->first();
        if(!$computer){
            return back()->withInput()->with("error", "El computador con el serial proporcionado no existe.");
        }
        // ( 3 )
        // obtener el objeto del usuario que sea el acusado de los daños, atraves del document_number de people
        // para obtener el id = $accused->users[0]->id 
       
        if($request->accused_document_number){
            $accused = Person::with("users")->where("document_number",$request->accused_document_number)->first();
            if(!$accused){
                    return back()->withInput()->with("error", "No existe un usuario con esa cedula.");
            }

        }
            
        //( 4 )
        // obtener la fecha actual
        $dateNew = Carbon::now();

        // ( 4 )
        // asiggnacion relacionada para saber quien era el responsable de ese elemento en momento que se hizo el reporte

        // en caso de que el computador este asignado de manera diaria se ara responsable a la persona del dia
        if($computer->status_assignment_day){
            // buscar el registro mas reciente de asignaciones y buscar cual esta relacionado con el computador actual
            $responsible_allocation = ComputerUserAssignment::where("computer_id",$computer->id)->first();
           
   
        }elseif($computer->status_assignment_formation){
        //En caso de que el computador no este asignado de manera diaria pero si en formacion se asignara al usuario de formacion como responsable
              $responsible_allocation = ComputerUserAssignment::where("computer_id",$computer->id)->first();
        }else{
            $responsible_allocation = [];
        }


        // Crear el reporte
        Report::create([
            'title' => $request->title,
            'description' => $request->description,
            'answer' => null,
            'status_reports' => $status_report,
            'computer_id' =>  $computer->id  ,
            'involved_id' => $involved,
           'accused_id' => $accused->users[0]->id ?? null,
            'responsible_allocation_id' => $responsible_allocation->id ?? null ,
            'reported_at' => $dateNew,
            'resolved_at' => null
        ]);

        


        return redirect()->route("gpes.cuentadante.reports.index")->with("success","Se hizo el reporte correctamente");

        // dd($involved,$status_report,$computer,$acused->toArray());


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
        $report = Report::findOrFail($id);
        if($report->status_reports == "in_progress" || $report->status_reports == "resolved"){
            return redirect()->route('gpes.cuentadante.reports.index')->with('error', 'Este reporte ya fue revisado no puedes eliminarlo.');    
        } 
        $report->delete();
        return redirect()->route('gpes.cuentadante.reports.index')->with('success', 'Reporte eliminado correctamente.');
    }
}
