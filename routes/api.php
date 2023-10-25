<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\GrupoController;
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
    Route::post("/TareaCreate", [TareaController::class, "Create"]);
    Route::put("/TareaModificate/{d}", [TareaController::class, "Update"]);
    Route::delete("/Tarea/{d}", [TareaController::class, "Delete"]);
    Route::get("/TareaRead", [TareaController::class, "Read"]);
    Route::get("/TareaReadOne/{d}", [TareaController::class, "ReadOne"]);
    Route::get("/TareaReadForGroup/{d}", [TareaController::class, "ReadForGroup"]);

    Route::post("/GrupoCreate", [GrupoController::class, "Create"]);
    Route::post("/Unirse", [GrupoController::class, "CrearTieneUnirse"]);
    Route::put("/GrupoModificate/{d}", [GrupoController::class, "Update"]);
    Route::delete("/Grupo/{d}", [GrupoController::class, "Delete"]);
    Route::get("/GrupoRead/{d}", [GrupoController::class, "Read"]);
    Route::get("/MyGroups/{d}", [GrupoController::class, "MyGroups"]);
    Route::get("/GruposUnidos/{d}", [GrupoController::class, "MyGroupsUnidos"]);
    Route::delete("/DeleteTiene/{d}", [GrupoController::class, "DeleteMeOnTheGroup"]);
})->middleware(Autenticator::class);