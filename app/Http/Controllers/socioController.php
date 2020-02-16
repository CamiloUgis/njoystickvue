<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cliente;
use App\Socio;
use Malahierba\ChileRut\ChileRut;
use Malahierba\ChileRut\Rules\ValidChileanRut;

class SocioController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $socios = Socio::join('clientes','socios.idClientes','=','clientes.idClientes')
            ->select('socios.idClientes', 'clientes.nombreClientes','socios.estadoSocios')
            ->orderBy('idClientes', 'desc')->paginate(5);
        }else{
            $socios = Socio::join('clientes','socios.idClientes','=','clientes.idClientes')
            ->select('socios.idClientes', 'clientes.nombreClientes','socios.estadoSocios')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('idClientes', 'desc')->paginate(5);
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
        $socio->Socio_idClientes=$request->input('Socio_idClientes');
        $socio->estadoSocios= 1;
        $socio->puntosSocios = 0;
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
        $socio = Socio::findOrFail($request->idClientes);;
        $socio->idClientes=$request->input('idClientes');
        $socio->Socio_idClientes=$request->input('Socio_idClientes');
        $socio->save();

    }
    public function equipo($idSocios){
        $socios=Socio::all();
        $soc=Socio::where('idSocios',$idSocios)->first();
        $socios2=Socio::where('idSocios', $soc->idSocios)->first();
        $refs=Socio::where('anfitrionSocios',$soc->idSocios)->get();
        $anfLinea1=Socio::where('idSocios', $socios2->anfitrionSocios)->first();
        
        return view('socios.socequipo')->with('socios', $socios)->with('soc', $soc)->with('anf', $anfLinea1)->with('refs',$refs);
    }


}
