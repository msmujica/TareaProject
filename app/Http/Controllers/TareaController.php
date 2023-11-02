<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Tarea;

class TareaController extends Controller
{
    public function Create(Request $request, $UserId){
        $tarea = new Tarea();

        $tarea -> Nombre = $request -> Nombre;
        $tarea -> Descripcion = $request -> Descripcion;
        $tarea -> FechaEntrega = $request -> FechaEntrega;
        $tarea -> IdGrupo = $request -> IdGrupo;

        $tarea -> save();

        return $tarea;
    }

    public function Update(Request $request, $IdTarea){
        $tarea = Tarea::findOrFail($IdTarea);

        $tarea -> Nombre = $request -> Nombre;
        $tarea -> Descripcion = $request -> Descripcion;
        $tarea -> FechaEntrega = $request -> FechaEntrega;
        $tarea -> IdGrupo = $request -> IdGrupo;

        $tarea -> save();

        return $tarea;
    }

    public function Delete(Request $request, $IdTarea){
        $tarea = Tarea::findOrFail($IdTarea);
        $tarea -> delete();

        return ["resultado" => "Tarea Eliminada"];
    }

    public function Read(Request $request){
        return Tarea::all();
    }

    public function ReadOne(Request $request, $IdTarea){
        return Tarea::findOrFail($IdTarea);
    }

    public function ReadForGroup(Request $request, $IdGrupo){
        return Tarea::where("IdGrupo", "=", $IdGrupo)->get();
    }
}
