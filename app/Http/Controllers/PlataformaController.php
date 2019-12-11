<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plataforma;
class PlataformaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plataformas = Plataforma::all();
        return $plataformas;
    }

    public function lista(){
        $plataformas=Plataforma::simplePaginate(20)->all();
        return view('plataformas.listaPlataforma')->with('plataformas', $plataformas);
    }
    public function agregar()
    {
        $plataformas=Plataforma::all();
        return view('plataformas.plataformaingresar')->with('plataformas', $plataformas);
    }
    public function actualizar($idPlataformas)
    {
        $plataformas=Plataforma::all();
        $pla=Plataforma::where('idPlataformas',$idPlataformas)->first();
        return view('plataformas.plataformaactualizar')->with('plataformas', $plataformas)->with('pla',$pla);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $plataformas=Plataforma::all();

        $validar= $request->validate([
            'nombrePlataformas'=>'required|unique:plataformas,nombrePlataformas',
            'descripcionPlataformas'=>'required',
          
        ]);
        $plataforma = new Plataforma();
        $plataforma->nombrePlataformas = $request->input('nombrePlataformas');
        $plataforma->descripcionPlataformas = $request->input('descripcionPlataformas');
        $plataforma->cantNuevoPlataformas= 0;
        $plataforma->cantUsadoPlataformas= 0;

        $plataforma->save();
        return redirect('/plataformas');

        
    }

    
    public function update(Request $request, $id)
    {
        $plataformas=Plataforma::all();

        $validar= $request->validate([
            'nombrePlataformas'=>'required',
            'descripcionPlataformas'=>'required',
            
            
            
        ]);
        $plataforma = Plataforma::findOrFail($request->idPlataformas);;
        $plataforma->nombrePlataformas = $request->input("nombrePlataformas");
        $plataforma->descripcionPlataformas = $request->input("descripcionPlataformas");
        
        $plataforma->save();
        return redirect('/plataformas');
        
    }

    
}
