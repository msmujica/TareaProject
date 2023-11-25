<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class MailTest extends TestCase
{
   use WithoutMiddleware;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_enviar(){
        $datosParaIngresar = [
           'from' => 'mail@mail.com',
           'to' => 'jose@jose.com',
           'subject' => 'PruebaPruebaPrueba'
        ];
        
        $response = $this
        ->withHeaders(["Accept" => "application/json"])
        ->post('api/v1/enviar', $datosParaIngresar);
        
        $response -> assertStatus(200);
     }

     public function test_SendHelp(){
        Cache::set("ABCD",[ "id" => 10, "email" => "coso@coso.com"]);
        
        $datosParaIngresar = [
            'subject' => 'PruebaPruebaPrueba'
         ];

         $response = $this
        ->withHeaders(["Accept" => "application/json", "Authorization" => "Bearer ABCD"])
        ->post('api/v1/GrupoCreate', $datosParaIngresar);
      
        $response -> assertStatus(200);
     }
}
