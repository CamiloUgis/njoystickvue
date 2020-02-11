<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Genero;

class GeneroController extends Controller
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
            $generos = Genero::orderBy('idGeneros', 'desc')->paginate(5);
        }else{
            $generos = Genero::where($criterio, 'like', '%'. $buscar . '%')->orderBy('idGeneros', 'desc')->paginate(5);
        }
        return [
            'pagination' =>[
                'total' => $generos->total(),
                'current_page'=> $generos->currentPage(),
                'per_page'=> $generos->perPage(),
                'last_page'=>$generos->lastPage(),
                'from'=>$generos->firstItem(),
                'to'=>$generos->lastItem(),
            ],
            'generos'=>$generos

        ] ;
    }
    public function selectGeneros(Request $request){
        if(!$request->ajax()) return redirect('/');
        $generos = DB::table('generos')
        ->select('idGeneros', 'nombreGeneros')->orderBy('nombreGeneros', 'asc')->get();
        return ['generos' => $generos];

    }


    public function store(Request $request)
    {
        // $validar= $request->validate([
        //     'nombreGeneros'=>'required',
        //     'descripcionGeneros'=>'required',
        // ]);
        if(!$request->ajax()) return redirect('/');
        $genero = new Genero();
        $genero->nombreGeneros = $request->input('nombreGeneros');
        $genero->descripcionGeneros = $request->input('descripcionGeneros');
       
        $genero->save();
    }

    public function update(Request $request)
    {
        $validar= $request->validate([
            'nombreGeneros'=>'required',
            'descripcionGeneros'=>'required',
        ]);
        if(!$request->ajax()) return redirect('/');
        $genero = Genero::findOrFail($request->idGeneros);;
        $genero->nombreGeneros = $request->input("nombreGeneros");
        $genero->descripcionGeneros = $request->input("descripcionGeneros");
       
        $genero->save();       
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
