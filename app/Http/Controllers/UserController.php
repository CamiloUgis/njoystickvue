<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Rol;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $productos = User::join('roles','usuarios.idRoles','=','roles.idRoles')
            ->select('usuarios.nickUsuarios', 'roles.nombreRoles')
            ->orderBy('usuarios.idRoles', 'desc')->paginate(8);
        }else{
            $productos = User::join('roles','usuarios.idRoles','=','roles.idRoles')
            ->select('usuarios.nickUsuarios', 'roles.nombreRoles')
            ->where('usuarios.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('usuarios.idRoles', 'desc')->paginate(8);
        }
        return [
            'pagination' =>[
                'total' => $productos->total(),
                'current_page'=> $productos->currentPage(),
                'per_page'=> $productos->perPage(),
                'last_page'=>$productos->lastPage(),
                'from'=>$productos->firstItem(),
                'to'=>$productos->lastItem(),
            ],
            'productos'=>$productos

        ] ;
    }

    public function store(Request $request)
    {

        if(!$request->ajax()) return redirect('/');
            $usuario = new User();
            $usuario->idUsuarios = $request->input('idUsuarios');
            $usuario->nickUsuarios = $request->input('nickUsuarios');
            $usuario->password = bcrypt($request->input('password'));
            $usuario->idRoles = $request->input('idRoles');
            $usuario->save();
    }
}

