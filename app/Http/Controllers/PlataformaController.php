<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Plataforma;
class PlataformaController extends Controller
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
            $plataformas = Plataforma::orderBy('idPlataformas', 'desc')->paginate(5);
        }else{
            $plataformas = Plataforma::where($criterio, 'like', '%'. $buscar . '%')->orderBy('idPlataformas', 'desc')->paginate(5);
        }
        return [
            'pagination' =>[
                'total' => $plataformas->total(),
                'current_page'=> $plataformas->currentPage(),
                'per_page'=> $plataformas->perPage(),
                'last_page'=>$plataformas->lastPage(),
                'from'=>$plataformas->firstItem(),
                'to'=>$plataformas->lastItem(),
            ],
            'plataformas'=>$plataformas

        ] ;
    }
    
    public function selectPlataformas(Request $request){
        if(!$request->ajax()) return redirect('/');
        $plataformas = DB::table('plataformas')
        ->select('idPlataformas', 'nombrePlataformas')->orderBy('nombrePlataformas', 'asc')->get();
        return ['plataformas' => $plataformas];

    }

    
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $validar= $request->validate([
            'nombrePlataformas'=>'required|unique:plataformas,nombrePlataformas',
            
        ]);
        $plataforma = new Plataforma();
        $plataforma->nombrePlataformas = $request->input('nombrePlataformas');
        $plataforma->descripcionPlataformas = $request->input('descripcionPlataformas');
       
        $plataforma->save();
    }

    
    public function update(Request $request)
    {

        if(!$request->ajax()) return redirect('/');
        
        $validar= $request->validate([
            'nombrePlataformas'=>'required|unique:plataformas,nombrePlataformas',
             
        ]);
        $plataforma = Plataforma::findOrFail($request->idPlataformas);;
        $plataforma->nombrePlataformas = $request->input("nombrePlataformas");
        $plataforma->descripcionPlataformas = $request->input("descripcionPlataformas");
       
        $plataforma->save();       
    }

    
}
