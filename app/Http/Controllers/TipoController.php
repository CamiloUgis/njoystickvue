<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Tipo;

class TipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $tipos = Tipo::orderBy('idTipos', 'desc')->paginate(5);
        }else{
            $tipos = Tipo::where($criterio, 'like', '%'. $buscar . '%')->orderBy('idTipos', 'desc')->paginate(5);
        }
        return [
            'pagination' =>[
                'total' => $tipos->total(),
                'current_page'=> $tipos->currentPage(),
                'per_page'=> $tipos->perPage(),
                'last_page'=>$tipos->lastPage(),
                'from'=>$tipos->firstItem(),
                'to'=>$tipos->lastItem(),
            ],
            'tipos'=>$tipos

        ] ;
    }
    public function selectTipos(Request $request){
        if(!$request->ajax()) return redirect('/');
        $tipos = DB::table('tipos')
        ->select('idTipos', 'nombreTipos')->orderBy('nombreTipos', 'asc')->get();
        return ['tipos' => $tipos];

    }


    public function store(Request $request)
    {
        $validar= $request->validate([
            'nombreTipos'=>'required',
            'descripcionTipos'=>'required',
        ]);
        if(!$request->ajax()) return redirect('/');
        $tipo = new Tipo();
        $tipo->nombreTipos = $request->input('nombreTipos');
        $tipo->descripcionTipos = $request->input('descripcionTipos');
       
        $tipo->save();
    }

    public function update(Request $request)
    {
        $validar= $request->validate([
            'nombreTipos'=>'required',
            'descripcionTipos'=>'required',
        ]);
        if(!$request->ajax()) return redirect('/');
        $tipo = Tipo::findOrFail($request->idTipos);;
        $tipo->nombreTipos = $request->input("nombreTipos");
        $tipo->descripcionTipos = $request->input("descripcionTipos");
       
        $tipo->save();       
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
