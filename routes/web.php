<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/type_operation', [App\Http\Controllers\TypeOperationController::class, 'index'])->name('type-operation.index');
Route::get('/type_operation/create', [App\Http\Controllers\TypeOperationController::class, 'create'])->name('type-operation.create');
Route::post('/type_operation/store', [App\Http\Controllers\TypeOperationController::class, 'store'])->name('type-operation.store');
Route::get('/type_operation/edit/{id}', [App\Http\Controllers\TypeOperationController::class, 'edit'])->name('type-operation.edit');
Route::put('/type_operation/update/{id}', [App\Http\Controllers\TypeOperationController::class, 'update'])->name('type-operation.update');
Route::delete('/type_operation/delete/{id}', [App\Http\Controllers\TypeOperationController::class, 'delete'])->name('type-operation.delete');


Route::get('/', [App\Http\Controllers\SaisieController::class, 'index'])->name('saisies.index');
Route::get('/saisies/create', [App\Http\Controllers\SaisieController::class, 'create'])->name('saisies.create');
Route::post('/saisies/store', [App\Http\Controllers\SaisieController::class, 'store'])->name('saisies.store');
Route::get('/saisies/edit/{id}', [App\Http\Controllers\SaisieController::class, 'edit'])->name('saisies.edit');
Route::put('/saisies/update/{id}', [App\Http\Controllers\SaisieController::class, 'update'])->name('saisies.update');
Route::delete('/saisies/delete/{id}', [App\Http\Controllers\SaisieController::class, 'delete'])->name('saisies.delete');
