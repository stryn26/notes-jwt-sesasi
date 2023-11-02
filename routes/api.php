<?php

use App\Http\Controllers\AuthRegisterController;
use App\Http\Controllers\NotesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


//user management
Route::post('register', [AuthRegisterController::class,'register']);
Route::post('login', [AuthRegisterController::class,'login']);
Route::post('approve_editor/{$id}', [AuthRegisterController::class,'approve_editor']);
Route::get('logout',[AuthRegisterController::class,'logout']);

//main notes management
Route::prefix('notes')->group(function () {
    Route::get('/', [NotesController::class, 'index'])->middleware('auth');
    Route::post('/', [NotesController::class, 'store']);//membuat catatan baru 
    Route::get('/{id}', [NotesController::class, 'show']);//get by id
    Route::put('/{id}', [NotesController::class, 'update']);//update by id
    Route::delete('/{id}', [NotesController::class, 'destroy']);//delete by id
});
