<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TicketController;
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

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/log-in', [AuthController::class, 'login'])->name('login.custom'); 
Route::get('/signout', [AuthController::class, 'signOut'])->name('signout');

Route::middleware(['auth'])->group(function () {
    Route::get('/Dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/crear-ticket', [TicketController::class, 'VerCrearTicket'])->name('ver.crearticket');

    Route::post('/guardar-ticket', [TicketController::class, 'GuardarTicket'])->name('guardar.ticket');
    Route::get('/ticket/{ticket}', [TicketController::class, 'mostrarTicket'])->name('ticket.mostrado');
    Route::get('/Solicitudes-Sin-Asignar', [TicketController::class, 'VerSolicitudesSinAsignar'])->name('ver.solicitudes.totales');


    Route::post('/tickets/asignar', [TicketController::class, 'asignarTicket'])->name('asignar');
    Route::get('/tickets/get-users', [TicketController::class, 'getUsersByTicket'])->name('tickets.get-users');

    Route::get('/mis-solicitudes', [TicketController::class, 'verMisSolicitudes'])->name('vista-missolicitudes');

    Route::get('/Solicitudes-globales', [TicketController::class, 'verSolicitudesGlobales'])->name('vista-solit-global');
    Route::get('/editar/{id}/ver', [TicketController::class, 'VerEditarTicket'])->name('ver.Editar');
    Route::post('/editar/{id}', [TicketController::class, 'GuardarEditar'])->name('guardar.editar');
    Route::prefix('/ticketsdel')->group(function() {
        Route::delete('/{id}', [TicketController::class, 'EliminarTicket']);
    });

    Route::get('/tickets/cerrar/{id}', [TicketController::class, 'CerrarTicket'])->name('cerrar.ticket');
    Route::get('/tickets/cerrados', [TicketController::class, 'VerCerrados'])->name('ver.cerrados');

    Route::get('/tickets/abiertos', [TicketController::class, 'verTicketsAbiertos'])->name('ver.abiertos');
    Route::post('/tickets/{ticket}/actualizar/estado', [TicketController::class, 'actualizarEstado'])->name('tickets.actualizar.estado');


    Route::get('/export-tickets', [DashboardController::class, 'exportData'])->name('tickets.export');


});