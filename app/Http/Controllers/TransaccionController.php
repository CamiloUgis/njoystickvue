<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaccion;
use App\Cliente;
use App\Socio;

class TransaccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transacciones=Transacciones::all();
        return $transacciones;
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
    /*public function store(Request $request)
    {
        //
    }*/
    public function viewPuntos(){
        $socios=Socio::all();
        return view('transacciones.transaccionesmain')->with('socios', $socios);
        
    }
    public function lista(){
        $transacciones=Transaccion::all()->sortByDesc("idTransacciones");
        return view('transacciones.listatransacciones')->with('transacciones', $transacciones);
    }
    public function asignapuntos(Request $request){
        $validar= $request->validate([
            'puntos'=>'required',
            'idSocio'=>'required'

        ]);
        $socios=Socio::all();
        Socio::find($request->input("idSocio"))->increment('puntosSocios',$request->input("puntos"));
       
        $transacciones=new Transaccion;
        $transacciones->tipoTransacciones=$request->input("optionsRadios");
        $transacciones->puntosTransacciones=$request->input("puntos");
        $transacciones->socio_id=$request->input("idSocio");
        $transacciones->save();
        
         
        $socios2=Socio::where('idSocios', $request->input("idSocio"))->first();
        
        $anfLinea1=Socio::where('idSocios', $socios2->anfitrionSocios)->first();
         $anfLinea1->increment('puntosSocios',($request->input("puntos")/2));
         $anfLinea2=Socio::where('idSocios', $anfLinea1->anfitrionSocios)->first();
         $anfLinea2->increment('puntosSocios',($request->input("puntos")));
         return view('transacciones.transaccionesmain')->with('socios', $socios);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
