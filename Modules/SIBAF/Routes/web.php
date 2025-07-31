<?php

use Illuminate\Support\Facades\Route;
use Modules\SIBAF\Http\Controllers\Instructor\InstructorInventoryController;
use Modules\SIBAF\Http\Controllers\Admin\InventoryController;
use Modules\SIBAF\Http\Controllers\Admin\DamageReportController;
use Modules\SIBAF\Http\Controllers\Admin\NotificationController;
use Modules\SIBAF\Http\Controllers\SIBAFController;

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

Route::middleware(['lang'])->group(function(){
    Route::prefix('sibaf')->group(function() {
        Route::get('/index', 'SIBAFController@index')->name('cefa.sibaf.index');
        Route::get('/admin/welcome', 'SIBAFController@admin')->name('sibaf.admin.welcome');
        Route::get('/soporte/welcomesoporte', 'SIBAFController@supportPanel')->name('sibaf.soporte.welcomesoporte');
        Route::get('/instructor/masterinstructor', 'SIBAFController@instructor')->name('sibaf.instructor.masterinstructor');
        Route::get('/instructor/inventoriesINS', 'SIBAFController@instructor')->name('sibaf.instructor.inventoriesINS');
    });
});

Route::middleware(['auth'])->group(function () {
    // Rutas para admin
    Route::get('/admin/inventories', [InventoryController::class, 'index'])->name('admin.sibaf.inventory.index');

    // Rutas para instructor
    Route::get('/instructor/inventories', [InventoryController::class, 'index'])->name('instructor.sibaf.inventor.index');

    // Rutas para reportes de daño
    Route::post('admin/sibaf/damage-reports', [DamageReportController::class, 'store'])
        ->middleware('check.computer.status')
        ->name('admin.sibaf.damage_reports.store');
    Route::post('/soporte/damage-reports/{id}/approve', [DamageReportController::class, 'approve'])->name('sibaf.support.damage_reports.approve');
    Route::post('/soporte/damage-reports/{id}/reject', [DamageReportController::class, 'reject'])->name('sibaf.support.damage_reports.reject');
    
    // Rutas del admin de SIBAF
    Route::prefix('sibaf/admin')->group(function () {
        Route::get('/notifications', [NotificationController::class, 'index'])->name('sibaf.admin.notifications');
        Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('sibaf.admin.notifications.mark-read');
        Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('sibaf.admin.notifications.mark-all-read');
        Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('sibaf.admin.notifications.destroy');
        Route::delete('/notifications/delete-all-read', [NotificationController::class, 'destroyAllRead'])->name('sibaf.admin.notifications.destroy-all-read');
        Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('sibaf.admin.notifications.unread-count');
        Route::get('/notifications/recent', [NotificationController::class, 'getRecent'])->name('sibaf.admin.notifications.recent');
        Route::get('/downgrades', [SIBAFController::class, 'downgrades'])->name('sibaf.admin.downgrades');
        Route::get('/downgrades/{downgrade}/download/{fileType}', [SIBAFController::class, 'downloadExcel'])->name('sibaf.admin.downgrades.download');
    });
});

Route::get('/inventario', [InstructorInventoryController::class, 'index'])->name('sibaf.instructor.inventario.index');
