<?php

use App\Http\Controllers\PuestosController;
use App\Models\Puestos;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/alumno', function () {
        return Inertia::render('Alumno/Index');
    })->name('alumno.index');
Route::resource('puestos', PuestosController::class)
    ->names('puestos');
    
});
require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
