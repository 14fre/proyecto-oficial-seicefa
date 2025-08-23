<?php

use Illuminate\Support\Facades\Route;
use Modules\SIBAF\Http\Controllers\Instructor\InstructorInventoryController;
use Modules\SIBAF\Http\Controllers\Admin\InventoryController;
use Modules\SIBAF\Http\Controllers\Admin\DamageReportController;
use Modules\SIBAF\Http\Controllers\Admin\NotificationController;
use Modules\SIBAF\Http\Controllers\SIBAFController;
use Modules\SIBAF\Http\Controllers\ManualController;

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

Route::middleware(['lang'])->group(function () {
    Route::prefix('sibaf')->group(function () {
        Route::get('/index', [SIBAFController::class, 'index'])->name('cefa.sibaf.index');
        Route::get('/admin/welcome', [SIBAFController::class, 'admin'])->name('sibaf.admin.welcome');
        Route::get('/soporte/welcomesoporte', [SIBAFController::class, 'supportPanel'])->name('sibaf.soporte.welcomesoporte');
        Route::get('/instructor/masterinstructor', [SIBAFController::class, 'instructor'])->name('sibaf.instructor.masterinstructor');
        Route::get('/instructor/inventoriesINS', [SIBAFController::class, 'instructor'])->name('sibaf.instructor.inventoriesINS');
        
    });
});

Route::middleware(['auth'])->group(function () {
    // Rutas para admin
    Route::get('/admin/inventories', [InventoryController::class, 'index'])->name('admin.sibaf.inventory.index');
    Route::get('/admin/equipment_tracking', [InventoryController::class, 'equipmentTracking'])->name('admin.sibaf.equipment_tracking.index');
    Route::get('/admin/damage_reports_tracking', [\Modules\SIBAF\Http\Controllers\EquipmentTrackingController::class, 'index'])->name('admin.sibaf.damage_reports_tracking.index');
    
    // Rutas para instructor
    Route::get('/instructor/inventories', [InventoryController::class, 'index'])->name('instructor.sibaf.inventory.index');

    // Rutas para reportes de daño
    Route::prefix('admin/sibaf')->group(function () {
        Route::post('/damage-reports', [DamageReportController::class, 'store'])
            ->middleware('check.computer.status')
            ->name('admin.sibaf.damage_reports.store');
    });

    // Rutas para soporte
    Route::prefix('soporte')->group(function () {
        Route::post('/damage-reports/{id}/approve', [DamageReportController::class, 'approve'])->name('sibaf.support.damage_reports.approve');
        Route::post('/damage-reports/{id}/reject', [DamageReportController::class, 'reject'])->name('sibaf.support.damage_reports.reject');
        Route::post('/damage-reports/{id}/mark-as-available', [DamageReportController::class, 'markAsAvailable'])->name('admin.sibaf.damage_reports.mark_as_available');
    });

    // Rutas del admin de SIBAF (Notificaciones y Bajas)
    Route::prefix('sibaf/admin')->name('sibaf.admin.')->group(function () {
        // Notificaciones
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
        Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
        Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
        Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
        Route::delete('/notifications/delete-all-read', [NotificationController::class, 'destroyAllRead'])->name('notifications.destroy-all-read');
        Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unread-count');
        Route::get('/notifications/recent', [NotificationController::class, 'getRecent'])->name('notifications.recent');
        
        // Bajas de equipos
        Route::get('/downgrades', [SIBAFController::class, 'downgrades'])->name('downgrades');
        Route::get('/downgrades/{downgrade}/download/{fileType}', [SIBAFController::class, 'downloadExcel'])->name('downgrades.download');
    });

    // Rutas para descarga de manuales
    Route::get('/manual/download/{role?}', [ManualController::class, 'download'])->name('sibaf.manual.download');
});

// Rutas públicas
Route::get('/inventario', [InstructorInventoryController::class, 'index'])->name('sibaf.instructor.inventario.index');
Route::post('/damage-reports/{id}/mark-as-available', [DamageReportController::class, 'markAsAvailable'])->name('admin.sibaf.damage_reports.mark_as_available');

Route::middleware(['auth'])->group(function () {
    Route::prefix('instructor')->name('sibaf.instructor.')->group(function () {
       Route::get('/instructor/inventories', [InventoryController::class, 'index'])->name('instructor.sibaf.inventory.index');
         Route::get('/inventory', [InstructorInventoryController::class, 'index'])->name('inventory.index');
    });
});