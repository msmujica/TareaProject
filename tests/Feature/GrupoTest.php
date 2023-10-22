<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GrupoTest extends TestCase
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
        "IdPersonaCreador",
        "created_at",
        "updated_at"
     ];

     public function Test_Read(){
        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->get('/api/v1/GrupoRead');
        
        $response -> assertStatus(200);
        $response -> assertJsonStructure(
            $this->campos
        );
     }

     public function Test_Create(){
        $datosParaIngresar = [
            "Nombre" => "GrupoGrupo",
            "Descripcion" => "GrupoGrupoGrupoGrupoGrupoGrupo",
            "IdPersonaCreador" => 2
        ];

        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->post('/api/v1/GrupoCreate');

        $response -> assertStatus(201);
        $response -> assertJsonStructure($campos);
        $response -> assertJsonFragment($datosParaIngresar);
        $response -> assertDatabaseHas('Grupo', $datosParaIngresar);
     }

     public function Test_NonCreate(){
        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->post('/api/v1/GrupoCreate');

        $response -> assertStatus(404);
        $response -> assertJsonFragment([
            "message" => ""
        ]);
     }

     public function Test_Delete(){
        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->post('/api/v1/Grupo/1');
                
        $response -> assertStatus(200);
        $response -> assertJsonStatus([
            "message" => "Grupo Eliminado"
        ]);

        $response -> assertDatabaseMissing("Grupo",[
            "id" => 1,
            "deleted_at" => null
        ]);
     }

     public function Test_NonDelete(){
        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->post('/api/v1/Grupo/1000');

        $response -> assertStatus(404);
        $response -> assertJsonFragment([
            "message" => "No query results for model [App\\Models\\Grupo] 1000"
        ]);
     }

     public function Test_ModicateGrupo(){
        $datosParaModificar = [
            "Nombre" => "SoreteGrupo",
            "Descripcion" => "Bienvenido a Soretes Team",
            "IdPersonaGrupo" => 1
        ];

        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->put('/api/v1/Grupo/1', $datosParaModificar);

        $response -> assertStatus(200);
        $response -> assertJsonStructure($this -> campos);
        $response -> assertJsonFragment($datosParaModificar);
     }

     public function Test_NonModificateGrupo(){
        $datosParaModificar = [
            "Nombre" => "SoreteGrupo",
            "Descripcion" => "Bienvenido a Soretes Team",
            "IdPersonaGrupo" => 1
        ];

        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->put('/api/v1/Grupo/1000', $datosParaModificar);

        $response -> assertStatus(404);
        $response -> assertJsonFragment([
            "message" => "No query results for model [App\\Model\\Grupo\]1000"
        ]);
     }
}
