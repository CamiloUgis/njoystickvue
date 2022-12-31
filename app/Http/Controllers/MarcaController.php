<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Marca;
class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $marcas = Marca::orderBy('idMarcas', 'desc')->paginate(5);
        }else{
            $marcas = Marca::where($criterio, 'like', '%'. $buscar . '%')->orderBy('idMarcas', 'desc')->paginate(5);
        }
        return [
            'pagination' =>[
                'total' => $marcas->total(),
                'current_page'=> $marcas->currentPage(),
                'per_page'=> $marcas->perPage(),
                'last_page'=>$marcas->lastPage(),
                'from'=>$marcas->firstItem(),
                'to'=>$marcas->lastItem(),
            ],
            'marcas'=>$marcas

        ] ;
    }
    
    public function selectMarcas(Request $request){
        if(!$request->ajax()) return redirect('/');
        $marcas = DB::table('marcas')
        ->select('idMarcas', 'nombreMarcas')->orderBy('nombreMarcas', 'asc')->get();
        return ['marcas' => $marcas];

    }

    
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $validar= $request->validate([
            'nombreMarcas'=>'required|unique:marcas,nombreMarcas',
            
        ]);
        $Marca = new Marca();
        $Marca->nombreMarcas = $request->input('nombreMarcas');
        $Marca->descripcionMarcas = $request->input('descripcionMarcas');
       
        $Marca->save();
    }

    
    public function update(Request $request)
    {

        if(!$request->ajax()) return redirect('/');
        
        $validar= $request->validate([
            'nombreMarcas'=>'required',
             
        ]);
        $Marca = Marca::findOrFail($request->idMarcas);;
        $Marca->nombreMarcas = $request->input("nombreMarcas");
        $Marca->descripcionMarcas = $request->input("descripcionMarcas");
       
        $Marca->save();       
    }

    
}
