<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TareaTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    private $campos = [
        "id",
        "Nombre",
        "Descripcion",
        "FechaEntrega",
        "IdGrupo",
        "created_at",
        "updated_at"
     ];

     public function test_Create(){
        $datosParaIngresar = [
            "Nombre" => "TareaTarea",
            "Descripcion" => "TareaTareaTareaTareaTareaTarea",
            "FechaEntrega" => "2023-12-31 00:00:00",
            "IdGrupo" => 1
        ];

        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->post('/api/v1/TareaCreate', $datosParaIngresar);

        $response -> assertStatus(201);
        $response -> assertJsonStructure($this-> campos);
        $response -> assertJsonFragment($datosParaIngresar);
     }

     public function test_Update(){
        $datosParaModificar = [
            "Nombre" => "Modificado",
            "Descripcion" => "Modificadp",
            "FechaEntrega" => "2023-12-31 12:00:00",
            "IdGrupo" => 1
        ];

        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->put('/api/v1/TareaModificate/3', $datosParaModificar);

        $response -> assertStatus(200);
        $response -> assertJsonStructure($this -> campos);
        $response -> assertJsonFragment($datosParaModificar);
     }

     public function test_Read(){
         
        $response = $this
                    -> withHeaders(["Accept" => "application/json"])
                    ->get('/api/v1/TareaRead');
        
        $response -> assertStatus(200);
        $response -> assertJsonStructure([
            "*" => $this -> campos
        ]);
     }

     public function test_ReadOne(){
        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->get('/api/v1/TareaReadOne/2');
        
        $response -> assertStatus(200);
        $response -> assertJsonStructure(
            $this -> campos
        );
     }

     public function test_ReadForGroup(){
        $response = $this
                    -> withHeaders(["Accept" => "application/json"])
                    ->get('/api/v1/TareaReadForGroup/1');
        
        $response -> assertStatus(200);
        $response -> assertJsonStructure([
            "*" => $this -> campos
        ]);
     }

     public function test_DeleteTarea(){
        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->delete('/api/v1/Tarea/12');

        $response -> assertStatus(200);
        $response -> assertJsonFragment([
            "resultado" => "Tarea Eliminada"
        ]);
     }

     public function test_NonReadOne(){
        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->get('/api/v1/TareaReadOne/1000');

        $response -> assertStatus(404);
     }

     public Function test_NonUpdate(){
        $datosParaModificar = [
            "Nombre" => "Sorete",
            "Descripcion" => "SoreteSoreteSoreteSoreteSorete",
            "FechaEntrega" => "2023-12-31 12:00:00",
            "IdGrupo" => 1
        ];

        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->put('/api/v1/Tarea/1000', $datosParaModificar);

        $response -> assertStatus(405);
     }

     public function test_nonDelete(){
        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->delete('/api/v1/Tarea/1000');

        $response -> assertStatus(404);
        $response -> assertJsonFragment([
            "message" => "No query results for model [App\\Models\\Tarea] 1000"
        ]);
     }
}