<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\Tiene;
use Illuminate\Support\Facades\Http;

class GrupoController extends Controller
{
    public function Create(Request $request){
        $grupo = new Grupo();

        $grupo -> Nombre = $request -> Nombre;
        $grupo -> Descripcion = $request -> Descripcion;

        $grupo -> save();

        $tokenHeader = [ "Authorization" => $request -> header("Authorization")];
        $response = Http::withHeaders($tokenHeader)->get(getenv("API_AUTH_URL") . "/validate");
        $User = json_decode($response);

        return $this->CrearTiene($grupo, $User);
    }

    public function CrearTiene($grupo, $User){
        $tiene = new Tiene();

        $tiene -> IdUser = $User -> id;
        $tiene -> IdGrupo = $grupo -> id;
        $tiene -> Rol = 'Administrador'; 

        $tiene -> save();

        return $tiene;
    }


    public function CrearTieneUnirse(Request $request){
        $tokenHeader = [ "Authorization" => $request -> header("Authorization")];
        $response = Http::withHeaders($tokenHeader)->get(getenv("API_AUTH_URL") . "/validate");
        $User = json_decode($response);
        
        $tiene = new Tiene();

        $tiene -> IdUser = $User -> Id;
        $tiene -> IdGrupo = $request -> IdGrupo;
        $tiene -> Rol = "Usuario";

        $tiene ->  save();

        return $tiene;
    }

    public function Update(Request $request, $idGrupo){
        $grupo = Grupo::findOrFail($idGrupo);

        $grupo -> Nombre = $request -> Nombre;
        $grupo -> Descripcion = $request -> Descripcion;

        $grupo -> save();

        return $grupo;
    }

    public function Delete(Request $request, $idGrupo){
        $grupo = Grupo::findOrFail($idGrupo);
        $grupo -> delete();

        return ["message" => "Grupo Eliminado"];
    }

    public function DeleteMeOnTheGroup(Request $request, $idTiene){
        $tiene = Tiene::findOrFail($idTiene);

        $tiene -> delete();

        return ["message" => "Se Elimino Tiene"];
    }

    public function Read(Request $request){
        return Grupo::all();
    }


    //Ver, creo que se puede eliminar el request.
    public function MyGroups(Request $request){

        $tokenHeader = [ "Authorization" => $request -> header("Authorization")];
        $response = Http::withHeaders($tokenHeader)->get(getenv("API_AUTH_URL") . "/validate");
        $User = json_decode($response);

        return Grupo::join("tienes", "tienes.IdGrupo", "=", "grupos.id")
                        ->select("grupos.id", "grupos.nombre", "grupos.descripcion")
                            ->where("tienes.IdUser", "=", $User->id,)
                                ->where("tienes.Rol", "=", "Administrador")
                                    ->get();
    }

    public function MyGroupsUnidos(Request $request, $idUser){
        return Grupo::join("tienes", "tienes.IdGrupo", "=", "grupos.id")
                        ->select("*")
                            ->where("tienes.IdUser", "=", $idUser,)
                                ->where("tienes.Rol", "=", "Usuario")
                                    ->get();
    }
}
