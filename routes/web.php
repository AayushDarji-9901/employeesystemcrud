<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

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


Route::get('/employee/index',[EmployeeController::class,'index'])->name('employee.index');
Route::get('/employee/create',[EmployeeController::class,'create'])->name('employee.create');
Route::post('/employee/search',[EmployeeController::class,'search'])->name('employee.search');
//Route::post('/employee/search',[EmployeeController::class,'search'])->name('employee.search');
Route::post('/employee/store',[EmployeeController::class,'store'])->name('employee.store');
Route::get('/employee/statistics',[EmployeeController::class,'statistics'])->name('employee.statistics');
