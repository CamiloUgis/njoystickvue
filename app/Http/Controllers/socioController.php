<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cliente;
use App\Socio;
use App\Transaccion;
use Malahierba\ChileRut\ChileRut;
use Malahierba\ChileRut\Rules\ValidChileanRut;
use Illuminate\Support\Facades\DB;


class SocioController extends Controller
{
    public function index(Request $request)
    {
        // if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $socios = Socio::join('clientes','socios.idClientes','=','clientes.idClientes')
            ->select('socios.idClientes', 'clientes.nombreClientes','socios.estadoSocios', 
            'socios.puntosPropiosSocios','socios.puntosReferidosSocios','socios.invitador')
            ->orderBy('idClientes', 'desc')->paginate(10);
        }else{
            $socios = Socio::join('clientes','socios.idClientes','=','clientes.idClientes')
            ->select('socios.idClientes', 'clientes.nombreClientes','socios.estadoSocios',
            'socios.puntosPropiosSocios','socios.puntosReferidosSocios','socios.invitador')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('idClientes', 'desc')->paginate(10);
        }
        return [
            'pagination' =>[
                'total' => $socios->total(),
                'current_page'=> $socios->currentPage(),
                'per_page'=> $socios->perPage(),
                'last_page'=>$socios->lastPage(),
                'from'=>$socios->firstItem(),
                'to'=>$socios->lastItem(),
            ],
            'socios'=>$socios

        ] ;
    }
    public function store(Request $request)
    {
        // $validar= $request->validate([
        //     'nombreClientes'=>'required',
        //     'rutClientes'=> ['required', 'string', new ValidChileanRut(new ChileRut)],
        //     'rutClientes'=>'required|unique:clientes,rutClientes',

        //     ]);
        if(!$request->ajax()) return redirect('/');
        $socio = new Socio();
        $socio->idClientes=$request->input('idClientes');
        $socio->invitador=$request->input('invitador');
        $socio->estadoSocios= 1;
        $socio->puntosPropiosSocios = 0;
        $socio->puntosReferidosSocios = 0;
        $socio->save();
    }


    public function update(Request $request)
    {
        // $validar= $request->validate([
        //     'nombreClientes'=>'required',
        //     'rutClientes'=> ['required', 'string', new ValidChileanRut(new ChileRut)],
        //     'rutClientes'=>'required|unique:clientes,rutClientes',
        //     'telefonoClientes'=>'required|unique:clientes,telefonoClientes',
        //     'telefonoClientes'=>'integer|min:0',
        //     'comunaClientes'=>'required',
        //     'correoClientes'=>'required',
        //     ]);
        if(!$request->ajax()) return redirect('/');
        $socio = Socio::findOrFail($request->idClientes);
        $socio->idClientes=$request->input('idClientes');
        $socio->invitador=$request->input('invitador');
        $socio->save();

    }
    public function equipo(Request $request){
       // if(!$request->ajax()) return redirect('/');
       $filtro = $request->filtro;
       /* $socio= Socio::findOrFail($request->idClientes);
        $referidos= DB::table('socios')
        ->join('clientes','socios.idClientes','=','clientes.idClientes')
        ->select('socios.idClientes', 'clientes.nombreClientes','socios.estadoSocios', 'socios.puntosSocios')
        ->where('invitador',$request->idClientes)->get(); */
        $socio=Socio::where('idClientes', 'like', '%'. $filtro. '%')
        ->join('clientes','socios.idClientes','=','clientes.idClientes')
        ->select('socios.idClientes', 'clientes.nombreClientes', 'socios.puntosPropiosSocios', 'socios.puntosReferidosSocios')
        ->first();
        $referidos = Socio::where('invitador', 'like', '%'. $filtro. '%')
        ->join('clientes','socios.idClientes','=','clientes.idClientes')
        ->select('socios.idClientes', 'clientes.nombreClientes', 'socios.puntosPropiosSocios', 'socios.puntosReferidosSocios')
        ->orderBy('clientes.nombreClientes', 'asc')->get();
        
        
        return ['referidos'=> $referidos]->with('socio', $socio);
    }
    public function selectSocio(Request $request){
        if(!$request->ajax()) return redirect('/');
        $socios = DB::table('socios')
        ->select('idClientes')->orderBy('idClientes', 'asc')->get();
        return ['socios' => $socios];

    }
    // public function asignaPuntos(){
    //     $socios = Socio::join('clientes','socios.idClientes','=','clientes.idClientes')
    //     ->join('transacciones', 'clientes.idClientes','=','transacciones.idClientes')
    //     ->select('transacciones.idTransacciones','transacciones.puntosTransacciones','socios.idClientes','socios.invitador')->orderBy('transacciones.idTransacciones', 'asc')->get();
    //     foreach($socios as $socio){
    //         if(!($socio->idClientes==99)){
    //         $invitador=Socio::where('idClientes', $socio->invitador)->first();
    //         $invitador->increment('puntosReferidosSocios', ($socio->puntosTransacciones)/2);
    //         $invitador->save();                
    //         }
    //     }

    //     return['invitador'=>$invitador];
    // }


}
