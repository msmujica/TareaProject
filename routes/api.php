<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\MailController;
use App\Http\Middleware\Autenticator;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function(){
    Route::post("/TareaCreate", [TareaController::class, "Create"])->middleware(Autenticator::class);
    Route::put("/TareaModificate/{d}", [TareaController::class, "Update"])->middleware(Autenticator::class);
    Route::delete("/Tarea/{d}", [TareaController::class, "Delete"])->middleware(Autenticator::class);
    Route::get("/TareaRead", [TareaController::class, "Read"])->middleware(Autenticator::class);
    Route::get("/TareaReadOne/{d}", [TareaController::class, "ReadOne"])->middleware(Autenticator::class);
    Route::get("/TareaReadForGroup/{d}", [TareaController::class, "ReadForGroup"])->middleware(Autenticator::class);

    Route::post("/GrupoCreate", [GrupoController::class, "Create"])->middleware(Autenticator::class);
    Route::post("/Unirse", [GrupoController::class, "CrearTieneUnirse"])->middleware(Autenticator::class);
    Route::put("/GrupoUpdate/{d}", [GrupoController::class, "Update"])->middleware(Autenticator::class);
    Route::delete("/Grupo/{d}", [GrupoController::class, "Delete"])->middleware(Autenticator::class);
    Route::get("/GrupoRead", [GrupoController::class, "Read"])->middleware(Autenticator::class);
    Route::get("/MyGroups", [GrupoController::class, "MyGroups"])->middleware(Autenticator::class);
    Route::get("/GruposUnidos/{d}", [GrupoController::class, "MyGroupsUnidos"])->middleware(Autenticator::class);
    Route::delete("/DeleteTiene/{d}", [GrupoController::class, "DeleteMeOnTheGroup"])->middleware(Autenticator::class);

    Route::post('/enviar',[MailController::class,'Send'])->middleware(Autenticator::class);
    Route::get('/UserData/{d}',[GrupoController::class,'UsersData'])->middleware(Autenticator::class);
});