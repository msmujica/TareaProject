<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Jobs\JobEmails;
use App\Models\Tarea;

class TareaController extends Controller
{
    public function Create(Request $request){
        $tarea = new Tarea();

        $tarea -> Nombre = $request -> Nombre;
        $tarea -> Descripcion = $request -> Descripcion;
        $tarea -> FechaEntrega = $request -> FechaEntrega;
        $tarea -> IdGrupo = $request -> IdGrupo;

        $tarea -> save();

        $UserData = Cache::get(explode(" ", $request -> header("Authorization"))[1]);

        return $tarea;
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
