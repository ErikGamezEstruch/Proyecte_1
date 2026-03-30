<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ControllerProjectes;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ComentariController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {

    // Clientes
    Route::get('/client/index', [ClientController::class, 'index'])->name('client.index');

    Route::get('/client/create', [ClientController::class, 'create'])->name('client.create');

    Route::get('/client/{id}/edit', [ClientController::class, 'edit'])->name('client.edit');

    Route::patch('/client/{id}', [ClientController::class, 'update'])->name('client.update')->middleware('role:ADMIN,GESTOR');

});


require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/proyects/index', [ControllerProjectes::class, 'index'])->name('proyects.index');
    Route::get('/proyects/create', [ControllerProjectes::class, 'create'])->name('proyects.create');
    Route::get('/proyects/{id}', [ControllerProjectes::class, 'show'])->name('proyects.show');
    Route::get('/proyects/{id}/edit', [ControllerProjectes::class, 'edit'])->name('proyects.edit');
    Route::patch('/proyects/{id}', [ControllerProjectes::class, 'update'])->name('proyects.update');
    Route::post('/proyects/{id}/assign-dev', [ControllerProjectes::class, 'assignDev'])->name('project.assignDev');
    Route::post('/proyects', [ControllerProjectes::class, 'store'])->name('proyects.store');
    Route::delete('/proyects/{id}', [ControllerProjectes::class, 'destroy'])->name('proyects.destroy');
    Route::post('projectes/{projecte}/tickets/{ticket}/temps', [TicketController::class, 'storeTime'])->name('tickets.storeTime');
});
Route::post('projectes/{projecte}/tickets/{ticket}/change-status', [TicketController::class, 'changeStatus'])->name('tickets.changeStatus');
Route::post('tickets/{ticket}/comentaris', [ComentariController::class, 'store'])->name('comentaris.store');
Route::prefix('projectes/{projecte}')->group(function () {
    Route::get('tickets', [TicketController::class, 'index'])->name('projectes.tickets.index');
    Route::get('tickets/create', [TicketController::class, 'create'])->name('projectes.tickets.create');
    Route::post('tickets', [TicketController::class, 'store'])->name('projectes.tickets.store');
    Route::get('tickets/{ticket}', [TicketController::class, 'show'])->name('projectes.tickets.show');
    Route::get('tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('projectes.tickets.edit');
    Route::put('tickets/{ticket}', [TicketController::class, 'update'])->name('projectes.tickets.update');
    Route::delete('tickets/{ticket}', [TicketController::class, 'destroy'])->name('projectes.tickets.destroy');
});
Route::delete('comentaris/{comentari}', [ComentariController::class, 'destroy'])->name('comentaris.destroy');
