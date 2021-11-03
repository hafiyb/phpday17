<?php

use App\Http\Controllers\AdminController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::any('/', [AdminController::class, 'index']);
});

Route::any('/dashboard', [AdminController::class, 'dashboard']);

Route::any('/employee/{id}/{action}', [AdminController::class, 'employee']);
Route::any('/employeeedit/{id}', [AdminController::class, 'employeeedit']);
Route::any('/employeeadd', [AdminController::class, 'employeeadd']);

Route::any('/job/{id}/{action}', [AdminController::class, 'job']);
Route::any('/jobedit/{id}', [AdminController::class, 'jobedit']);
Route::any('/jobadd', [AdminController::class, 'jobadd']);

Route::any('/department/{id}/{action}', [AdminController::class, 'department']);
Route::any('/departmentedit/{id}', [AdminController::class, 'departmentedit']);
Route::any('/departmentadd', [AdminController::class, 'departmentadd']);

// Route::any('/employee/delete/{id}', [AdminController::class, 'delete']);

Route::any('/logout', [AdminController::class, 'logout']);
