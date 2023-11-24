<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use Illuminate\Support\Facades\Cache;

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
   
   public function test_Create(){
      Cache::set("ABCD",[ "id" => 10, "email" => "coso@coso.com"]);
      $datosParaIngresar = [
         'Nombre' => 'GrupoGrupo',
         'Descripcion' => 'GrupoGrupoGrupoGrupoGrupoGrupo'
      ];
      
      $response = $this
      ->withHeaders(["Accept" => "application/json", "Authorization" => "Bearer ABCD"])
      ->post('api/v1/GrupoCreate', $datosParaIngresar);
      
      $response -> assertStatus(200);
   }
   
   public function test_Update(){
      $datosParaModificar = [
         "Nombre" => "Modificades",
         "Descripcion" => "Modificades"
      ];
      
      $response = $this
      ->withHeaders(["Accept" => "application/json"])
      ->put('/api/v1/GrupoUpdate/4', $datosParaModificar);
      
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

   public function test_MyGroups(){
      Cache::set("ABCD",[ "id" => 10, "email" => "coso@coso.com"]);
      $response = $this
      ->withHeaders(["Accept" => "application/json", "Authorization" => "Bearer ABCD"])
      ->get('api/v1/GrupoRead');
      
      $response -> assertStatus(200);
      $response -> assertJsonStructure([
         "*" => $this -> campos
      ]);
   }

   public function test_MyGroupsUnidos(){
      Cache::set("ABCD",[ "id" => 10, "email" => "coso@coso.com"]);
      $response = $this
      ->withHeaders(["Accept" => "application/json", "Authorization" => "Bearer ABCD"])
      ->get('api/v1/GrupoRead');
      
      $response -> assertStatus(200);
      $response -> assertJsonStructure([
         "*" => $this -> campos
      ]);
   }
   
   public function test_Delete(){
      $response = $this
      ->withHeaders(["Accept" => "application/json"])
      ->delete('/api/v1/Grupo/1');
      
      $response -> assertStatus(200);
   }
   
   public function test_NonDelete(){
      $response = $this
      ->withHeaders(["Accept" => "application/json"])
      ->post('/api/v1/Grupo/1000');
      
      $response -> assertStatus(405);
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
}