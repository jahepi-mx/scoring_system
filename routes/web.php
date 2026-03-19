<?php

use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\FactorController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TestController;
use App\Models\Factor;
use Illuminate\Support\Facades\Route;

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', [EvaluationController::class, 'index'])->name('evaluations.index');
Route::get('/test', [TestController::class, 'test']);
Route::get('/students', [StudentController::class, 'index'])->name('students.index');
Route::get('/evaluations', [EvaluationController::class, 'index'])->name('evaluations.index');
Route::post('/evaluations', [EvaluationController::class, 'store'])->name('evaluations.store');
Route::post('/evaluations/{evaluation}/import', [EvaluationController::class, 'importExcel'])->name('evaluations.import');
Route::get('/evaluations/{evaluation}/results', [EvaluationController::class, 'results'])->name('evaluations.results');
Route::get('/evaluations/{evaluation}/export-results', [EvaluationController::class, 'exportResults'])->name('evaluations.export_results');

Route::get('/evaluations/{evaluation}/factors', [FactorController::class, 'index'])->name('factors.index');
Route::post('/evaluations/{evaluation}/factors', [FactorController::class, 'store'])->name('factors.store');
Route::put('/evaluations/{evaluation}/factors/{factor}', [FactorController::class, 'update'])->name('factors.update');
Route::delete('/evaluations/{evaluation}/factors/{factor}', [FactorController::class, 'destroy'])->name('factors.destroy');
