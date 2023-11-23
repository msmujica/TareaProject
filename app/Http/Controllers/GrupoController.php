<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;
use App\Models\Tiene;
use App\Jobs\JobEmails;
use Illuminate\Support\Facades\Cache;

class GrupoController extends Controller
{
    public function Create(Request $request){
        $grupo = new Grupo();

        $grupo -> Nombre = $request -> Nombre;
        $grupo -> Descripcion = $request -> Descripcion;

        $grupo -> save();

        $UserData = Cache::get(explode(" ", $request -> header("Authorization"))[1]);
    
        return $this->CrearTiene($grupo, $UserData);
    }

    public function CrearTiene($grupo, $UserData){
        $tiene = new Tiene();

        $tiene -> IdUser = $UserData['id'];
        $tiene -> IdGrupo = $grupo -> id;
        $tiene -> Rol = 'Administrador'; 

        $tiene -> save();

        return $this->Send($UserData);
    }

    public function UserData(Request $request){
        
    }

    public function Send($UserData){
        
        $emailJob = new JobEmails(
            'System@tareasya.com',
            $UserData['email'],
            'Grupo Creado'
        );
        
        $this->dispatch($emailJob);
        return [ 'status' => 'success'];
    }

    public function CrearTieneUnirse(Request $request){
        $UserData = Cache::get(explode(" ", $request -> header("Authorization"))[1]);
        
        $tiene = new Tiene();

        $tiene -> IdUser = $UserData['id'];
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

    public function MyGroups(Request $request){
        $UserData = Cache::get(explode(" ", $request -> header("Authorization"))[1]);

        return Grupo::join("tienes", "tienes.IdGrupo", "=", "grupos.id")
                        ->select("grupos.id", "grupos.nombre", "grupos.descripcion")
                            ->where("tienes.IdUser", "=", $UserData['id'],)
                                ->where("tienes.Rol", "=", "Administrador")
                                    ->get();
    }

    public function MyGroupsUnidos(Request $request){
        $UserData = Cache::get(explode(" ", $request -> header("Authorization"))[1]);

        return Grupo::join("tienes", "tienes.IdGrupo", "=", "grupos.id")
                        ->select("*")
                            ->where("tienes.IdUser", "=", $UserData['id'],)
                                ->where("tienes.Rol", "=", "Usuario")
                                    ->get();
    }
}
