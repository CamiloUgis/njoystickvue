<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Cliente;
use Malahierba\ChileRut\ChileRut;
use Malahierba\ChileRut\Rules\ValidChileanRut;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $clientes = Cliente::orderBy('idClientes', 'asc')->paginate(10);
        }else{
            $clientes = Cliente::where($criterio, 'like', '%'. $buscar . '%')->orderBy('idClientes', 'asc')->paginate(10);
        }
        return [
            'pagination' =>[
                'total' => $clientes->total(),
                'current_page'=> $clientes->currentPage(),
                'per_page'=> $clientes->perPage(),
                'last_page'=>$clientes->lastPage(),
                'from'=>$clientes->firstItem(),
                'to'=>$clientes->lastItem(),
            ],
            'clientes'=>$clientes

        ] ;
    }
    public function selectClientes(Request $request){
        if(!$request->ajax()) return redirect('/');
        $clientes = DB::table('clientes')->select('*')
        ->whereNotIn('idClientes', function($query){
            $query->select('idClientes')->from('socios');
        })->orderBy('nombreClientes', 'asc')->get();
        return ['clientes' => $clientes];

    }
    public function transaccionClientes(Request $request){
        //if(!$request->ajax()) return redirect('/');
        $filtro = $request->filtro;
        $clientes = Cliente::where('nombreClientes', 'like', '%'. $filtro. '%')
        ->orWhere('rutClientes', 'like', '%'. $filtro. '%')
        ->select('idClientes', 'nombreClientes', 'rutClientes')
        ->orderBy('nombreClientes', 'asc')->get();

        return ['clientes'=>$clientes];

    }

    
    public function store(Request $request)
    {
        $validar= $request->validate([
            'nombreClientes'=>'required',
            'rutClientes'=> ['required', 'string', new ValidChileanRut(new ChileRut)],
            'rutClientes'=>'required|unique:clientes,rutClientes',
            'correoClientes'=>'nullable|email',
            'telefonoClientes'=>'nullable|numeric|min:0',
            ]);
        if(!$request->ajax()) return redirect('/');
        $cliente = new Cliente();
        $cliente->nombreClientes = $request->input('nombreClientes');
        $a= substr($request->input('rutClientes'),-1);
        $b= substr($request->input('rutClientes'),-4,-1);
        $c= substr($request->input('rutClientes'),-7,-4);
        $d= substr($request->input('rutClientes'),0,-7);
        $e= $d."." .$c."." .$b."-" .$a;
        $cliente->rutClientes = $e;
        $cliente->telefonoClientes = $request->input('telefonoClientes');
        $cliente->comunaClientes = $request->input('comunaClientes');
        $cliente->correoClientes = $request->input('correoClientes');
        $cliente->save();
    }


    public function update(Request $request)
    {
        $validar= $request->validate([
            'nombreClientes'=>'required',
            'rutClientes'=> ['required', 'string', new ValidChileanRut(new ChileRut)],
            'rutClientes'=>'required|unique:clientes,rutClientes',
            'telefonoClientes'=>'required|unique:clientes,telefonoClientes',
            'telefonoClientes'=>'integer|min:0',
            'comunaClientes'=>'required',
            'correoClientes'=>'required',
            ]);
        if(!$request->ajax()) return redirect('/');
        $cliente = Cliente::findOrFail($request->idClientes);;
        $cliente->nombreClientes = $request->input('nombreClientes');
        $cliente->rutClientes = $request->input('rutClientes');
        $cliente->telefonoClientes = $request->input('telefonoClientes');
        $cliente->comunaClientes = $request->input('comunaClientes');
        $cliente->correoClientes = $request->input('correoClientes');
        $cliente->save();

    }
    public function selectCliente2(Request $request){
        if(!$request->ajax()) return redirect('/');
        $clientes = DB::table('clientes')
        ->select('idClientes', 'nombreClientes')->orderBy('nombreClientes', 'asc')->get();
        return ['clientes' => $clientes];

    }


}
