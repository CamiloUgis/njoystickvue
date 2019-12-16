<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Rol;

class RolController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $roles = Rol::orderBy('idRoles', 'desc')->paginate(5);
        }else{
            $roles = Rol::where($criterio, 'like', '%'. $buscar . '%')->orderBy('idRoles', 'desc')->paginate(5);
        }
        return [
            'pagination' =>[
                'total' => $roles->total(),
                'current_page'=> $roles->currentPage(),
                'per_page'=> $roles->perPage(),
                'last_page'=>$roles->lastPage(),
                'from'=>$roles->firstItem(),
                'to'=>$roles->lastItem(),
            ],
            'roles'=>$roles

        ] ;
    }

    public function selectRoles(Request $request){
        if(!$request->ajax()) return redirect('/');
        $roles = DB::table('roles')
        ->select('idRoles', 'nombreRoles')->orderBy('nombreRoles', 'asc')->get();
        return ['roles' => $roles];

    }
}
