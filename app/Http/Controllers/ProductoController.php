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
            'productos.stockNuevoProductos', 'productos.stockUsadoProductos','productos.precioNuevoProductos',
            'productos.precioUsadoProductos','plataformas.nombrePlataformas','generos.nombreGeneros')
            ->orderBy('productos.idProductos', 'desc')->paginate(8);
        }else{
            $productos = Producto::join('plataformas','productos.idPlataformas','=','plataformas.idPlataformas')
            ->join('genero_producto','genero_producto.idProductos','=','productos.idProductos')
            ->join('generos', 'genero_producto.idGeneros', '=', 'generos.idGeneros')
            ->select('productos.idProductos', 'productos.idPlataformas','productos.nombreProductos', 'productos.descripcionProductos',
            'productos.stockNuevoProductos', 'productos.stockUsadoProductos','productos.precioNuevoProductos',
            'productos.precioUsadoProductos','plataformas.nombrePlataformas','generos.nombreGeneros')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('productos.idProductos', 'desc')->paginate(8);*/
            if($buscar==''){
                $productos = Producto::join('plataformas','productos.idPlataformas','=','plataformas.idPlataformas')
                ->select('productos.idProductos', 'productos.idPlataformas','productos.nombreProductos', 'productos.descripcionProductos',
                'productos.stockNuevoProductos', 'productos.stockUsadoProductos','productos.precioNuevoProductos',
                'productos.precioUsadoProductos','plataformas.nombrePlataformas')
                ->orderBy('productos.idProductos', 'desc')->paginate(8);
            }else{
                $productos = Producto::join('plataformas','productos.idPlataformas','=','plataformas.idPlataformas')
                ->select('productos.idProductos', 'productos.idPlataformas','productos.nombreProductos', 'productos.descripcionProductos',
                'productos.stockNuevoProductos', 'productos.stockUsadoProductos','productos.precioNuevoProductos',
                'productos.precioUsadoProductos','plataformas.nombrePlataformas')
                ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
                ->orderBy('productos.idProductos', 'desc')->paginate(8);
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
        ->select('idProductos', 'nombreProductos', 'precioNuevoProductos', 'precioUsadoProductos', 'stockNuevoProductos', 'stockUsadoProductos')->orderBy('nombreProductos', 'asc')->take(1)->get();

        return ['productos'=>$productos];
    }
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $producto = new Producto();
        $producto->nombreProductos = $request->input('nombreProductos');
        $producto->descripcionProductos = $request->input('descripcionProductos');
        $producto->precioNuevoProductos = $request->input('precioNuevoProductos');
        $producto->precioUsadoProductos = $request->input('precioUsadoProductos');
        $producto->stockNuevoProductos = $request->input('stockNuevoProductos');
        $producto->stockUsadoProductos = $request->input('stockUsadoProductos');
        $producto->idPlataformas = $request->input('idPlataformas');
        $producto->save();    
    }
    public function update(Request $request)
    {

        if(!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->idProductos);
        $producto->nombreProductos = $request->input('nombreProductos');
        $producto->idPlataformas = $request->input('idPlataformas');
        $producto->descripcionProductos = $request->input('descripcionProductos');
        $producto->precioNuevoProductos = $request->input('precioNuevoProductos');
        $producto->precioUsadoProductos = $request->input('precioUsadoProductos');
        $producto->stockNuevoProductos = $request->input('stockNuevoProductos');
        $producto->stockUsadoProductos = $request->input('stockUsadoProductos');
        $producto->save();
    }
    public function asociar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        try{
            DB::beginTransaction();
            $pivote = $request->input('arrayGenerosSeleccionados');
     
            foreach($pivote as $ep){
                $gp = new GeneroProducto();  
                $gp->idProductos = $request->input('idProductos');
                $gp->idGeneros = $ep['idGeneros'];
                $gp->save();
            }
        }catch(Exception $e){
            DB::rollback();
        }
    }

    public function transaccionProducto(Request $request){
        if(!$request->ajax()) return redirect('/');
        $filtro = $request->filtro;
        $productos = Producto::where('nombreProductos', 'like', '%'. $filtro. '%')
        ->select('idProductos', 'nombreProductos', 'precioNuevoProductos', 'precioUsadoProductos', 'stockNuevoProductos', 'stockUsadoProductos')
        ->orderBy('nombreProductos', 'asc')->get();

        return ['productos'=>$productos];

    }
    public function selectProducto(Request $request){
        if(!$request->ajax()) return redirect('/');
        $productos = DB::table('productos')
        ->select('idProductos', 'nombreProductos')->orderBy('nombreProductos', 'asc')->get();
        return ['productos' => $productos];

    }


    
}
