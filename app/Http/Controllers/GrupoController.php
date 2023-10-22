<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\Tiene;

class GrupoController extends Controller
{
    public function Create(Request $request){
        $grupo = new Grupo();

        $grupo -> Nombre = $request -> Nombre;
        $grupo -> Descripcion = $request -> Descripcion;

        $grupo -> save();

        return $this->CrearTiene($grupo);
    }

    public function CrearTiene($grupo){
        $tiene = new Tiene();

        $tiene -> IdUser = 2;
        $tiene -> IdGrupo = $grupo -> id;
        $tiene -> Rol = 'Administrador'; 

        $tiene -> save();

        return $grupo;
    }

    public function CrearTieneUnirse(Request $request){
        $tiene = new Tiene();

        $tiene -> IdUser = $request -> IdUser;
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
        $grupo -> deletes();

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

    public function MyGroups(Request $request, $idUser){
        return Grupo::join("tienes", "tienes.IdGrupo", "=", "grupos.id")
                        ->select("grupos.nombre", "grupos.id")
                            ->where("tienes.IdUser", "=", $idUser,)
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
