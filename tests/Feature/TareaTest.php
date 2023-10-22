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
        "created_at",
        "updated_at"
     ];

     public function Test_Read(){
        $response = $this
                    -> withHeaders(["Accept" => "application/json"])
                    ->get('/api/v1/TareaRead');
        
        $response -> assertStatus(200);
        $response -> assertJsonStructure([
            "*" => $this -> campos
        ]);
     }

     public function Test_ReadOne(){
        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->get('/api/v1/TareaReadOne/2');
        
        $response -> assertStatus(200);
        $response -> assertJsonStructure(
            $this -> campos
        );
     }

     public function Test_NonReadOne(){
        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->get('/api/v1/TareaReadOne/1000');

        $response -> assertStatus(404);
        $response -> assertJsonFragment([
            "message" => "No query result for model [App\\Models\\Persona] 1000"
        ]);
     }

     public function Test_Create(){
        $datosParaIngresar = [
            "Nombre" => "TareaTarea",
            "Descripcion" => "TareaTareaTareaTareaTareaTarea",
            "FechaEntrega" => "2023-12-31 00:00:00"
        ];

        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->post('/api/v1/TareaCreate', $datosParaIngresar);

        $response -> assertStatus(201);
        $response -> assertJsonStructure($campos);
        $response -> assertJsonFragment($datosParaIngresar);
        $response -> assertDatabaseHas('Tarea' , $datosParaIngresar);
     }

     public function Test_NonCreate(){
        $datosParaIngresar = [
            "Nombre" => "TareaTareaTarea",
            "Descripcion" => "TareaTareaTareaTareaTareaTareaTarea",
            "FechaEntrega" => "2023-01-31 12:00:00"
        ];
        
        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->post('/api/v1/TareaCreate', $datosParaIngresar);
        
        $response -> assertStatus(404);
        $response -> assertJsonFragment([
            "message" => ""
        ]);
     }

     public function Test_DeleteTarea(){
        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->delete('/api/v1/Tarea/1');

        $response -> assertStatus(200);
        $response -> assertJsonFragment([
            "message" => "Tarea Eliminada"
        ]);
        $response -> assertDatabaseMissing("Tarea",[
            "id" => 1,
            "deleted_at" => null
        ]);
     }

     public function Test_NonDeleteTarea(){
        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->delete('/api/v1/Tarea/1000');

        $response -> assertStatus(404);
        $response -> assertJsonFragment([
            "message" => "No query results for model [App\\Models\\Tarea] 1000"
        ]);
     }

     public function Test_ModificateTarea(){
        $datosParaModificar = [
            "Nombre" => "Sorete",
            "Descripcion" => "SoreteSoreteSoreteSoreteSorete",
            "FechaEntrega" => "2023-12-31 12:00:00"
        ];

        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->put('/api/v1/Tarea/2', $datosParaModificar);

        $response -> assertSatus(200);
        $response -> assertJsonStructure($this -> campos);
        $response -> assertJsonFragment($datosParaModificar);
     }

     public Function Test_NonModificateTarea(){
        $datosParaModificar = [
            "Nombre" => "Sorete",
            "Descripcion" => "SoreteSoreteSoreteSoreteSorete",
            "FechaEntrega" => "2023-12-31 12:00:00"
        ];

        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->put('/api/v1/Tarea/1000', $datosParaModificar);

        $response -> assertStatus(404);
        $response -> assertJsonFragment([
            "message" => "No query results for model [App\\Models\\Tarea\] 1000"
        ]);
     }
}
