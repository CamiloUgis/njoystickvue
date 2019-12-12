<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use App\Plataforma;
use App\Genero;
class ProductoController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $productos = Producto::join('plataformas','productos.idPlataformas','=','plataformas.idPlataformas')
            ->select('productos.idProductos', 'productos.idPlataformas','productos.nombreProductos', 'productos.descripcionProductos',
            'productos.stockNuevoProductos', 'productos.stockUsadoProductos','productos.precioNuevoProductos',
            'productos.precioUsadoProductos','plataformas.nombrePlataformas')
            ->orderBy('productos.idProductos', 'desc')->paginate(8);
        }else{
            $productos = Producto::join('plataformas','productos.idPlataformas','=','plataformas.idPlataformas')
            ->select('productos.idProductos', 'productos.idPlataformas', 'productos.descripcionProductos',
            'productos.stockNuevoProductos', 'productos.stockUsadoProductos','productos.nombreProductos','productos.precioNuevoProductos',
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

    public function store(Request $request)
    {

        if(!$request->ajax()) return redirect('/');
        $producto = new Producto();
        $producto->idPlataformas = $request->input('idPlataformas');
        $producto->nombreProductos = $request->input('nombreProductos');
        $producto->descripcionProductos = $request->input('descripcionProductos');
        $producto->precioNuevoProductos = $request->input('precioNuevoProductos');
        $producto->precioUsadoProductos = $request->input('precioUsadoProductos');
        $producto->stockNuevoProductos = $request->input('stockNuevoProductos');
        $producto->stockUsadoProductos = $request->input('stockUsadoProductos');
        $producto->save();
    }


    public function update(Request $request)
    {

        if(!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->idProductos);;
        $producto->nombreProductos = $request->input('nombreProductos');
        $producto->idPlataformas = $request->input('idPlataformas');
        $producto->descripcionProductos = $request->input('descripcionProductos');
        $producto->precioNuevoProductos = $request->input('precioNuevoProductos');
        $producto->precioUsadoProductos = $request->input('precioUsadoProductos');
        $producto->stockNuevoProductos = $request->input('stockNuevoProductos');
        $producto->stockUsadoProductos = $request->input('stockUsadoProductos');
        $producto->save();
    }

    
}
