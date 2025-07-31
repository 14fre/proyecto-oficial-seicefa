<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Modules\GPES\Http\Controllers\AnswersController;
use Modules\GPES\Http\Controllers\AdminGPESController;
use Modules\GPES\Http\Controllers\GPESController;



use Modules\GPES\Http\Controllers\ComputerController;
use Modules\GPES\Http\Controllers\ComputerUserAssignmentController;
use Modules\GPES\Http\Controllers\ComputerUserAssignmentDayController;
use Modules\GPES\Http\Controllers\ComputerUserAssignmentFormationController;
use Modules\GPES\Http\Controllers\ElementController;
use Modules\GPES\Http\Controllers\NotificationController;
use Modules\GPES\Http\Controllers\PersonalHistoryController;
use Modules\GPES\Http\Controllers\ReportsController;
use Modules\GPES\Http\Controllers\SearchComputerHistoryController;
use Modules\GPES\Http\Controllers\SearchPersonHistoryController;
use NumberToWords\Legacy\Numbers\Words\Locale\Ro;



Route::prefix("gpes")->group(function () {
    Route::prefix("cuentadante")->group(function () {
        Route::prefix("computers")->group(function () {

            // Rutas para el usuario cuentadante
            Route::get("/", [ElementController::class, "index"])->name("gpes.cuentadante.computers.index");
            Route::get("/create", [ElementController::class, "create"])->name("gpes.cuentadante.computers.create");
            Route::post("/", [ElementController::class, "store"])->name("gpes.cuentadante.computers.store");
            Route::get("/{id}/edit", [ElementController::class, "edit"])->name("gpes.cuentadante.computers.edit");
            Route::put("/{id}", [ElementController::class, "update"])->name("gpes.cuentadante.computers.update");
            Route::delete("/{id}", [ElementController::class, "destroy"])->name("gpes.cuentadante.computers.destroy");
        });

        Route::prefix('assignmentsUserComputer')->group(function () {
            Route::prefix("day")->group(function () {
                // Rutas para asignaciones de computadores por dia
                Route::get('/', [ComputerUserAssignmentDayController::class, 'index'])->name('gpes.cuentadante.assignmentsUserComputer.day.index');
                Route::get('/create', [ComputerUserAssignmentDayController::class, 'create'])->name('gpes.cuentadante.assignmentsUserComputer.day.create');
                Route::post('/store', [ComputerUserAssignmentDayController::class, 'store'])->name('gpes.cuentadante.assignmentsUserComputer.day.store');
                Route::post("/{id}", [ComputerUserAssignmentDayController::class, "return"])->name("gpes.cuentadante.assignmentsUserComputer.day.return");
                Route::get('/{id}/edit', [ComputerUserAssignmentDayController::class, 'edit'])->name('gpes.cuentadante.assignmentsUserComputer.day.edit');
                Route::put('/{id}', [ComputerUserAssignmentDayController::class, 'update'])->name('gpes.cuentadante.assignmentsUserComputer.day.update');
                Route::delete('/{id}', [ComputerUserAssignmentDayController::class, 'destroy'])->name('gpes.cuentadante.assignmentsUserComputer.day.destroy');
                Route::patch('/{id}/return', [ComputerUserAssignmentDayController::class, 'return'])->name('gpes.cuentadante.assignmentsUserComputer.day.return');
            });

            // rutas para la asignacion de equipos por formacion
              Route::prefix("formation")->group(function () {
                // Rutas para asignaciones de computadores por dia
                Route::get('/', [ComputerUserAssignmentFormationController::class, 'index'])->name('gpes.cuentadante.assignmentsUserComputer.formation.index');
                Route::get('/create', [ComputerUserAssignmentFormationController::class, 'create'])->name('gpes.cuentadante.assignmentsUserComputer.formation.create');
                Route::post('/store', [ComputerUserAssignmentFormationController::class, 'store'])->name('gpes.cuentadante.assignmentsUserComputer.formation.store');
                Route::post("/{id}", [ComputerUserAssignmentFormationController::class, "return"])->name("gpes.cuentadante.assignmentsUserComputer.formation.return");
                Route::get('/{id}/edit', [ComputerUserAssignmentFormationController::class, 'edit'])->name('gpes.cuentadante.assignmentsUserComputer.formation.edit');
                Route::put('/{id}', [ComputerUserAssignmentFormationController::class, 'update'])->name('gpes.cuentadante.assignmentsUserComputer.formation.update');
                Route::delete('/{id}', [ComputerUserAssignmentFormationController::class, 'destroy'])->name('gpes.cuentadante.assignmentsUserComputer.formation.destroy');
                Route::patch('/{id}/return', [ComputerUserAssignmentFormationController::class, 'return'])->name('gpes.cuentadante.assignmentsUserComputer.formation.return');
            });
        });


         Route::prefix("reports")->group(function () {
                // Rutas para reportes de asignaciones de computadores
                Route::get('/', [ReportsController::class, 'index'])->name('gpes.cuentadante.reports.index');
                Route::get('/create', [ReportsController::class, 'create'])->name('gpes.cuentadante.reports.create');
                Route::post('/store', [ReportsController::class, 'store'])->name('gpes.cuentadante.reports.store');
                Route::get('/{id}/edit', [ReportsController::class, 'edit'])->name('gpes.cuentadante.reports.edit');
                Route::put('/{id}', [ReportsController::class, 'update'])->name('gpes.cuentadante.reports.update');
                Route::get('/{id}', [ReportsController::class, 'destroy'])->name('gpes.cuentadante.reports.destroy');
            });
            Route::prefix("answers")->group(function () {
                   Route::get('/', [AnswersController::class, 'index'])->name('gpes.cuentadante.answers.index');
                Route::get('/{id}/create', [answersController::class, 'create'])->name('gpes.cuentadante.answers.create');
                Route::post('/store', [answersController::class, 'store'])->name('gpes.cuentadante.answers.store');
                Route::get('/{id}/edit', [answersController::class, 'edit'])->name('gpes.cuentadante.answers.edit');
                Route::put('/{id}', [answersController::class, 'update'])->name('gpes.cuentadante.answers.update');
                Route::delete('/{id}', [answersController::class, 'destroy'])->name('gpes.cuentadante.answers.destroy');
            });


            Route::prefix("histori/person/computer")->group(function(){        
                Route::get('/', [PersonalHistoryController::class, 'index'])->name('gpes.cuentadante.personHistory.index');
            });

             Route::prefix("histori/computer/Search")->group(function(){        
                Route::get('/', [SearchComputerHistoryController::class, 'index'])->name('gpes.cuentadante.Search.computer.index');
                Route::get('/Computer', [SearchComputerHistoryController::class, 'Search'])->name('gpes.cuentadante.Search.computer.Search');
            });

               Route::prefix("histori/person/Search")->group(function(){        
                Route::get('/', [SearchPersonHistoryController::class, 'index'])->name('gpes.cuentadante.Search.person.index');
                Route::get('/person', [SearchPersonHistoryController::class, 'Search'])->name('gpes.cuentadante.Search.person.Search');
            });


                Route::prefix(" notification/Assigments")->group(function(){        
                Route::get('/', [NotificationController::class, 'index'])->name('gpes.cuentadante.notificationAssigments.index');
                Route::get('/{id}/person', [NotificationController::class, 'showNotification'])->name('gpes.cuentadante.notificationAssigments.showNotification');
            });
    });
});


   Route::prefix('GPES')->group(function () {
        //   Rutas para administrador
        Route::get('/welcome', [GPESController::class, "Welcome"])->name("cefa.gpes.welcome");
        Route::prefix('admin')->group(function () {

            Route::get('/', [AdminGPESController::class, "index"])->name("gpes.admin.dashboard");
        });


 });

use Illuminate\Support\Facades\Response;

 Route::get('/descargar-pdf/a', function () {
    $file = public_path('pdfs/Manual_de_usuario.pdf');
    return Response::download($file, 'Manual_de_usuario.pdf');
})->name('descargar.gpes.pdf');


Route::middleware(['lang'])->group(function () {
 

   
});


// ruta que cada ves que resiva la rais  la redireccione a home




// Ruta general que permite que todos puedan ingresar y visualizar algo del programa,
// En caso de tener roles se le permite vizualisar un boton para ingresar como usuario de ese rol

// ruta para hacer pruebas
Route::get("GPES/testing", [GPESController::class, "testing"])->name("gpes.testing");

// Rutas para evitar que salga error en el welcome porque el pendejo de jorge no hizo bien las cosas
Route::get("GPES/a1", [GPESController::class, "testing"])->name("gpes.apprentice.panel");
Route::get("GPES/a2", [GPESController::class, "testing"])->name("gpes.instructor.panel");
Route::get("GPES/a3", [GPESController::class, "testing"])->name("gpes.pasante.panel");
// ==================================================================================================
// ruta general para todos los usuarios logeados
Route::get("GPES/dashboard", [GPESController::class, "index"])->name("gpes.dashboard");
