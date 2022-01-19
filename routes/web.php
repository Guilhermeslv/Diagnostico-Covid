<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacientesController;
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
    return view('welcome');
});

Route::get('/pacientes-list',[PacientesController::class, 'index'])->name('pacientes.list');
Route::post('/pacientes-cad',[PacientesController::class, 'pacientesCad'])->name('pacientes.cad');
Route::get('/getPacientesList',[PacientesController::class, 'getPacientesList'])->name('get.pacientes.list');
Route::get('/pacienteDetalhes/{id}',[PacientesController::class, 'pacienteDetalhes'])->name('paciente.detalhes');