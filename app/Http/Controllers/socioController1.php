<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Socio;
use \App\Cliente;

class socioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $socios=Socio::all();
        return $socios;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function agregar($idClientes)
    {
        $socios=Socio::all();
        return view('socios.socingresar')->with('socios', $socios);
    }
    public function actualizar($idSocios)
    {
        $socios=Socio::all();
        $soc=Socio::where('idSocios',$idSocios)->first();
        return view('socios.socactualizar')->with('socios', $socios)->with('soc',$soc);
    }
    public function equipo($idSocios){
        $socios=Socio::all();
        $soc=Socio::where('idSocios',$idSocios)->first();
        $socios2=Socio::where('idSocios', $soc->idSocios)->first();
        $refs=Socio::where('anfitrionSocios',$soc->idSocios)->get();
        $anfLinea1=Socio::where('idSocios', $socios2->anfitrionSocios)->first();
        
        return view('socios.socequipo')->with('socios', $socios)->with('soc', $soc)->with('anf', $anfLinea1)->with('refs',$refs);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    public function store(Request $request)
    {
        $socios=Socio::all();
        $validar= $request->validate([
            'nombre'=>'required',
            'rut'=>'required|unique:socios,rutSocios',
            'telefono'=>'required|unique:socios,telefonoSocios',
            'comuna'=>'required',
            'correo'=>'required|unique:socios,correoSocios',

        ]);
        $socio=new Socio;
        $socio->nombreSocios = $request->input("nombre");
        $socio->rutSocios = $request->input("rut");
        $socio->telefonoSocios = $request->input("telefono");
        $socio->comunaSocios = $request->input("comuna");
        $socio->correoSocios = $request->input("correo");
        $socio->puntosSocios = 0;
        $socio->estadoSocios = 1;
        $socio->anfitrionSocios = $request->input("idAnfitrion", false);
        $socio->save();
        

        return view('socios.socingresar')->with('socios', $socios);

    }
    public function update(Request $request)
    {
       $socios=Socio::all();
        
        // $validar= $request->validate([
        //     'nombre'=>'required',
        //     'rut'=>'required|unique:socios,rutSocios',
        //     'telefono'=>'required|unique:socios,telefonoSocios',
        //     'comuna'=>'required',
        //     'correo'=>'required|unique:socios,correoSocios',

        // ]);
        $socio=Socio::where('idSocios',$request->input("id"))->first();
        $socio->nombreSocios = $request->input("nombre");
        $socio->rutSocios = $request->input("rut");
        $socio->telefonoSocios = $request->input("telefono");
        $socio->comunaSocios = $request->input("comuna");
        $socio->correoSocios = $request->input("correo");
        $socio->puntosSocios = $request->input("puntos");
        $socio->estadoSocios = $request->input("estado");
        $socio->anfitrionSocios = $request->input("idAnfitrion", false);
        $socio->save();
        $socios=Socio::all();

        return redirect('/');

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function lista(){
        $socios=Socio::simplePaginate(20)->all();
        return view('socios.listaSocio')->with('socios', $socios);
    }
   
    public function destroy($id)
    {
        //
    }
}
