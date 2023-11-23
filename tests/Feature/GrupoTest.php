<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class GrupoTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * A basic feature test example.
     *
     * @return void
     */

     private $campos = [
        "id",
        "Nombre",
        "Descripcion",
        "created_at",
        "updated_at",
        "deleted_at"
     ];

     public function test_Update(){
        $datosParaModificar = [
            "Nombre" => "Modificado",
            "Descripcion" => "Modificado"
        ];

        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->put('/api/v1/GrupoUpdate/1', $datosParaModificar);

        $response -> assertStatus(200);
        $response -> assertJsonStructure($this -> campos);
        $response -> assertJsonFragment($datosParaModificar);
     }

     public function test_Read(){
        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->get('api/v1/GrupoRead');
        
        $response -> assertStatus(200);
        $response -> assertJsonStructure([
            "*" => $this -> campos
        ]);
     }

     public function test_Delete(){
        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->post('/api/v1/Grupo/2');
                
        $response -> assertStatus(200);
        $response -> assertJsonStatus([
            "resultado" => "Grupo Eliminado"
        ]);
     }

     public function Test_NonDelete(){
        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->post('/api/v1/Grupo/1000');

        $response -> assertStatus(404);
     }

     public function test_NonUpdate(){
        $datosParaModificar = [
            "Nombre" => "Modificado",
            "Descripcion" => "Modificado"
        ];

        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->put('/api/v1/GrupoUpdate/1000', $datosParaModificar);

        $response -> assertStatus(404);
     }

     public function Test_Create(){
        $datosParaIngresar = [
            'Nombre' => 'GrupoGrupo',
            'Descripcion' => 'GrupoGrupoGrupoGrupoGrupoGrupo'
        ];

        $response = $this
                    ->withHeaders(["Accept" => "application/json"])
                    ->post('api/v1/GrupoCreate', $datosParaIngresar);

        $response -> assertStatus(201);
     }
}
