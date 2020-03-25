<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Producto;
use App\Plataforma;
use App\Genero;
use App\GeneroProducto;
class ProductoController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio = $request->criterio;
    /*
        if($buscar==''){
            $productos = Producto::join('plataformas','productos.idPlataformas','=','plataformas.idPlataformas')
            ->join('genero_producto','genero_producto.idProductos','=','productos.idProductos')
            ->join('generos', 'genero_producto.idGeneros', '=', 'generos.idGeneros')
            ->select('productos.idProductos', 'productos.idPlataformas','productos.nombreProductos', 'productos.descripcionProductos',
            'productos.stockProductos', 'productos.precioNuevoProductos',
            'productos.precioUsadoProductos','plataformas.nombrePlataformas','generos.nombreGeneros')
            ->orderBy('productos.idProductos', 'desc')->paginate(8);
        }else{
            $productos = Producto::join('plataformas','productos.idPlataformas','=','plataformas.idPlataformas')
            ->join('genero_producto','genero_producto.idProductos','=','productos.idProductos')
            ->join('generos', 'genero_producto.idGeneros', '=', 'generos.idGeneros')
            ->select('productos.idProductos', 'productos.idPlataformas','productos.nombreProductos', 'productos.descripcionProductos',
            'productos.stockProductos', 'productos.precioNuevoProductos',
            'productos.precioUsadoProductos','plataformas.nombrePlataformas','generos.nombreGeneros')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('productos.idProductos', 'desc')->paginate(8);*/
            if($buscar==''){
                $productos = Producto::join('plataformas','productos.idPlataformas','=','plataformas.idPlataformas')
                ->select('productos.idProductos', 'productos.idPlataformas','productos.nombreProductos', 'productos.descripcionProductos',
                'productos.stockProductos', 'productos.precioNuevoProductos',
                'productos.precioUsadoProductos','plataformas.nombrePlataformas')
                ->orderBy('productos.idProductos', 'desc')->paginate(10);
            }else{
                $productos = Producto::join('plataformas','productos.idPlataformas','=','plataformas.idPlataformas')
                ->select('productos.idProductos', 'productos.idPlataformas','productos.nombreProductos', 'productos.descripcionProductos',
                'productos.stockProductos', 'productos.precioNuevoProductos',
                'productos.precioUsadoProductos','plataformas.nombrePlataformas')
                ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
                ->orderBy('productos.idProductos', 'desc')->paginate(10);
            }
        return [
            'pagination' =>[
                'total' => $productos->total(),
                'current_page'=> $productos->currentPage(),
                'per_page'=> $productos->perPage(),
                'last_page'=>$productos->lastPage(),
                'from'=>$productos->firstItem(),
                'to'=>$productos->lastItem(),
            ],
            'productos'=>$productos

        ] ;
    }

    public function buscarProducto(Request $request){
        if(!$request->ajax()) return redirect('/');
        $filtro = $request->filtro;
        $productos = Producto::where('idProductos','=', $filtro)
        ->select('idProductos', 'nombreProductos', 'precioNuevoProductos', 'precioUsadoProductos', 'stockProductos')->orderBy('nombreProductos', 'asc')->take(1)->get();

        return ['productos'=>$productos];
    }
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $validar= $request->validate([
            'nombreProductos'=>'required|unique:productos,nombreProductos',
            'descripcionProductos'=>'nullable', 
            'precioNuevoProductos'=>'nullable|min:0',
            'precioUsadoProductos'=>'nullable|min:0',
            'stockProductos'=>'nullable|min:0',
            
        ]);
        try{
        DB::beginTransaction();
        $producto = new Producto();
        $producto->nombreProductos = $request->input('nombreProductos');
        $producto->descripcionProductos = $request->input('descripcionProductos');
        $producto->precioNuevoProductos = $request->input('precioNuevoProductos');
        $producto->precioUsadoProductos = $request->input('precioUsadoProductos');
        $producto->stockProductos = $request->input('stockProductos');
        $producto->idPlataformas = $request->input('idPlataformas');
        $producto->save();
        DB::commit();

        $pivote = $request->data;
     
            foreach($pivote as $ep=>$det){
                $ep = new GeneroProducto();  
                $ep->idProductos = $producto->idProductos;
                $ep->idGeneros = $det['idGeneros'];
                $ep->save();
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
        $producto->save();    
    }
    public function update(Request $request)
    {

        if(!$request->ajax()) return redirect('/');
        $validar= $request->validate([
            'nombreProductos'=>'required',
            'descripcionProductos'=>'required',
            'precioNuevoProductos'=>'required|min:0',
            'precioUsadoProductos'=>'required|min:0',
            'stockProductos'=>'required|min:0',
            
        ]);
        try{
        DB::beginTransaction();
        $producto = Producto::findOrFail($request->idProductos);
        $producto->nombreProductos = $request->input('nombreProductos');
        $producto->idPlataformas = $request->input('idPlataformas');
        $producto->descripcionProductos = $request->input('descripcionProductos');
        $producto->precioNuevoProductos = $request->input('precioNuevoProductos');
        $producto->precioUsadoProductos = $request->input('precioUsadoProductos');
        $producto->stockProductos = $request->input('stockProductos');
        DB::commit();

        // $pivote = $request->data;
     
        //     foreach($pivote as $ep=>$det){
        //         $ep = new GeneroProducto();  
        //         $ep->idProductos = $producto->idProductos;
        //         $ep->idGeneros = $det['idGeneros'];
        //         $ep->save();
        //     }
        //     DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
        $producto->save();    
    }
    public function transaccionProducto(Request $request){
        if(!$request->ajax()) return redirect('/');
        $filtro = $request->filtro;
        $productos = Producto::where('nombreProductos', 'like', '%'. $filtro. '%')
        ->select('idProductos', 'nombreProductos', 'precioNuevoProductos', 'precioUsadoProductos','stockProductos')
        ->orderBy('nombreProductos', 'asc')->get();

        return ['productos'=>$productos];

    }
    public function selectProducto(Request $request){
        if(!$request->ajax()) return redirect('/');
        $productos = DB::table('productos')
        ->select('idProductos', 'nombreProductos')->orderBy('nombreProductos', 'asc')->get();
        return ['productos' => $productos];

    }
    public function muestraGeneros(Request $request){
         //if(!$request->ajax()) return redirect('/');
         $generos = Producto::join('genero_producto', 'productos.idProductos', '=', 'genero_producto.idProductos')
         ->join('generos', 'genero_producto.idGeneros', '=', 'generos.idGeneros')
         ->select('genero_producto.idProductos','generos.nombreGeneros', 'productos.nombreProductos')
         ->orderBy('genero_producto.idProductos', 'asc')->get();
         
         
         return ['generos'=> $generos];
     }


    
}
