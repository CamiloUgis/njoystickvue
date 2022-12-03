<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Producto;
use App\Plataforma;
use App\Tipo;
use App\TipoProducto;
class ProductoController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio = $request->criterio;
/*
        if($buscar==''){
            $productos = Producto::join('marcas','productos.idMarcas','=','marcas.idMarcas')
            ->join('tipo_producto','tipo_producto.idProductos','=','productos.idProductos')
            ->join('tipos', 'tipo_producto.idTipos', '=', 'tipos.idTipos')
            ->select('productos.idProductos', 'productos.idMarcas','productos.nombreProductos', 'productos.descripcionProductos',
            'productos.stockProductos', 'productos.precioProductos',
            'marcas.nombrePlataformas','tipos.nombreTipos')
            ->orderBy('productos.idProductos', 'desc')->paginate(8);
        }else{
            $productos = Producto::join('marcas','productos.idMarcas','=','marcas.idMarcas')
            ->join('tipo_producto','tipo_producto.idProductos','=','productos.idProductos')
            ->join('tipos', 'tipo_producto.idTipos', '=', 'tipos.idTipos')
            ->select('productos.idProductos', 'productos.idMarcas','productos.nombreProductos', 'productos.descripcionProductos',
            'productos.stockProductos', 'productos.precioProductos',
            'marcas.nombrePlataformas','tipos.nombreTipos')
            ->where('productos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('productos.idProductos', 'desc')->paginate(8);*/
            if($buscar==''){
                $productos = Producto::join('marcas','productos.idMarcas','=','marcas.idMarcas')
                ->select('productos.idProductos', 'productos.idmarcas','productos.nombreProductos', 'productos.descripcionProductos',
                'productos.stockProductos', 'productos.precioProductos',
                'marcas.nombreMarcas')
                ->orderBy('productos.idProductos', 'desc')->paginate(8);
            }else{
                $productos = Producto::join('marcas','productos.idMarcas','=','marcas.idMarcas')
                ->select('productos.idProductos', 'productos.idMarcas','productos.nombreProductos', 'productos.descripcionProductos',
                'productos.stockProductos', 'productos.precioProductos',
                'marcas.nombrePlataformas')
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
        $producto->nombreProductos = $request->input('nombreProductos');
        $producto->descripcionProductos = $request->input('descripcionProductos');
        $producto->precioProductos = $request->input('precioProductos');
        $producto->stockProductos = $request->input('stockProductos');
        $producto->idMarcas = $request->input('idMarcas');
        $producto->save();    
    }
    public function update(Request $request)
    {

        if(!$request->ajax()) return redirect('/');
        $producto = Producto::findOrFail($request->idProductos);
        $producto->nombreProductos = $request->input('nombreProductos');
        $producto->idMarcas = $request->input('idMarcas');
        $producto->descripcionProductos = $request->input('descripcionProductos');
        $producto->precioProductos = $request->input('precioProductos');
        $producto->stockProductos = $request->input('stockProductos');
        $producto->save();
    }
    public function asociar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        try{
            DB::beginTransaction();
            $pivote = $request->input('arrayTiposSeleccionados');
     
            foreach($pivote as $ep){
                $gp = new TipoProducto();  
                $gp->idProductos = $request->input('idProductos');
                $gp->idTipos = $ep['idTipos'];
                $gp->save();
            }
        }catch(Exception $e){
            DB:rollback();
        }
    }

    
}
