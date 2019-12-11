<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Producto;
use App\Plataforma;
use App\Genero;
class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return $productos;

    }
    public function lista(){
        $productos=Producto::all();
        $plataformas=Plataforma::all();
        return view('productos.listaProducto')->with('productos', $productos)->with('plataformas', $plataformas);;
    }
    public function agregar()
    {
        $plataformas=Plataforma::all();
        
        $productos=Producto::all();
        $generos=Genero::all();
        
        return view('productos.productoingresar')->with('productos', $productos)->with('plataformas', $plataformas)->with('generos', $generos);
    }
    public function store(Request $request)
    {
        $productos=Producto::all();
        $validar= $request->validate([
            'nombreProductos'=>'required|unique:productos,nombreProductos',
            'descripcionProductos'=>'required',
            'stockNuevoProductos'=>'required',
            'stockNuevoProductos'=>'integer|min:0',
            'stockNuevoPlataformas'=>'required',
            'stockNuevoPlataformas'=>'integer|min:0',
            'precioNuevoProductos'=>'required',
            'precioNuevoProductos'=>'integer|min:0',
            'stockUsadoProductos'=>'required',
            'stockUsadoProductos'=>'integer|min:0', 
            'stockUsadoPlataformas'=>'required',
            'stockUsadoPlataformas'=>'integer|min:0',         
            'precioUsadoProductos'=>'required',
            'precioUsadoProductos'=>'integer|min:0'
            
        ]);
        
        $producto = new Producto();

        $producto->nombreProductos = $request->input('nombreProductos');
        $producto->descripcionProductos = $request->input('descripcionProductos');
        $producto->precioNuevoProductos = $request->input('precioNuevoProductos');
        $producto->precioUsadoProductos = $request->input('precioUsadoProductos');
        $producto->stockNuevoProductos = $request->input('stockNuevoPlataformas');
        $producto->stockUsadoProductos = $request->input('stockUsadoPlataformas');
        $producto->idPlataformas = $request->idPlataformas;
        $plataforma= Plataforma::findOrFail($request->idPlataformas);
        $plataforma->increment('cantNuevoPlataformas', ($request->input('cantNuevoPlataformas')));
        $plataforma->increment('cantUsadoPlataformas', ($request->input('cantUsadoPlataformas')));
        
        $plataforma->save();
        $producto->save();

        $generos= Genero::find([]);
        $producto->generos()->attach($generos);
        return redirect('/productos');
    }

    public function update(Request $request, $id)
    {
        $productos=Producto::all();

        $validar= $request->validate([
            'nombreProductos'=>'required',
            'descripcionProductos'=>'required',
            'stockProductos'=>'required',
            'stockProductos'=>'integer|min:0',
            'precioProductos'=>'required',
            'precioProductos'=>'integer|min:0'
            
        ]);
        $producto = Producto::findOrFail($request->idProductos);;
        $$producto->nombreProductos = $request->nombreProductos;
        $producto->descripcionProductos = $request->descripcionProductos;
        $producto->stockProductos = $request->stockProductos;
        $producto->precioProductos = $request->precioProductos;
        $producto->estadoProductos = 1;
        $producto->save();
        
    }

    public function desactivar(Request $request, $id)
    {
        $producto = Producto::findOrFail($request->idProductos);;
        $producto->estadoProductos = 0;
        $producto->save();
    }

    public function activar(Request $request, $id)
    {
        $producto = Producto::findOrFail($request->idProductos);;
        $producto->estadoProductos = 1;
        $producto->save();
    }
}
