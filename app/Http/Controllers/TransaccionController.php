<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Transaccion;
use App\Cliente;
use App\Producto;
use App\ProductoTransaccion;
use Carbon\Carbon;

class TransaccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       // if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio = $request->criterio;

        if($buscar==''){
            $transacciones = Transaccion::join('clientes','transacciones.idClientes','=','clientes.idClientes')
            ->join('producto_transaccion', 'transacciones.idTransacciones', '=', 'producto_transaccion.idTransacciones')
            ->join('productos', 'producto_transaccion.idProductos','=','productos.idProductos')
            ->select('transacciones.tipoTransacciones', 'transacciones.observacionTransacciones', 'transacciones.fechaTransacciones', 
            'transacciones.puntosTransacciones', 'transacciones.descuentoTransacciones', 'transacciones.valorFinalTransacciones', 'transacciones.formaPagoTransacciones',
            'transacciones.plazoTransacciones', 'transacciones.estadoTransacciones', 'clientes.nombreClientes', 'clientes.rutClientes', 
            'producto_transaccion.idTransacciones', 'productos.nombreProductos', 'productos.stockProductos',
            'productos.precioNuevoProductos', 'productos.precioUsadoProductos')
            ->orderBy('transacciones.idTransacciones', 'desc')->paginate(8);

        }else{
            $transacciones = Transaccion::join('clientes','transacciones.idClientes','=','clientes.idClientes')
            ->join('producto_transaccion', 'transacciones.idTransacciones', '=', 'producto_transaccion.idTransacciones')
            ->join('productos', 'producto_transaccion.idProductos','=','productos.idProductos')
            ->select('transacciones.tipoTransacciones', 'transacciones.observacionTransacciones', 'transacciones.fechaTransacciones', 
            'transacciones.puntosTransacciones', 'transacciones.descuentoTransacciones', 'transacciones.valorFinalTransacciones', 'transacciones.formaPagoTransacciones',
            'transacciones.plazoTransacciones', 'transacciones.estadoTransacciones', 'clientes.nombreClientes', 'clientes.rutClientes', 
            'producto_transaccion.idTransacciones', 'productos.nombreProductos', 'productos.stockProductos',
            'productos.precioNuevoProductos', 'productos.precioUsadoProductos')
            ->where('transacciones.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('transacciones.idTransacciones', 'desc')->paginate(8);
        }
        return [
            'pagination' =>[
                'total' => $transacciones->total(),
                'current_page'=> $transacciones->currentPage(),
                'per_page'=> $transacciones->perPage(),
                'last_page'=>$transacciones->lastPage(),
                'from'=>$transacciones->firstItem(),
                'to'=>$transacciones->lastItem(),
            ],
            'transacciones'=>$transacciones

        ] ;
    }

    public function store(Request $request)
    {

        if(!$request->ajax()) return redirect('/');
      /*  $validar= $request->validate([
            'descuentoTransacciones'=>'nullable|numeric|between:0,100',
            'tipoTransacciones'=>'required|not_in:0',
            'formaPagoTransacciones'=>'required|not_in:0',
            'estadoTransacciones'=>'required|not_in:0',
            'precioProductos'=>'required|min:0|not_in:0',
            'observacionTransacciones'=>'nullable|string',
        ]);*/
        try{
            DB::beginTransaction();
            $mytime= Carbon::now('America/Santiago');
            $transaccion = new Transaccion();
            $transaccion->idTransacciones = $request->input('idTransacciones');
            $transaccion->tipoTransacciones = $request->input('tipoTransacciones');
            $transaccion->fechaTransacciones = $mytime->toDateString();
            $transaccion->observacionTransacciones = $request->input('observacionTransacciones');
            $transaccion->puntosTransacciones = $request->input('puntosTransacciones');
            $transaccion->descuentoTransacciones = $request->input('descuentoTransacciones');
            $transaccion->valorFinalTransacciones = $request->input('valorFinalTransacciones');
            $transaccion->formaPagoTransacciones = $request->input('formaPagoTransacciones');
            $transaccion->plazoTransacciones = $request->input('plazoTransacciones');
            $transaccion->estadoTransacciones = $request->input('estadoTransacciones');
            $transaccion->idClientes = $request->input('idClientes');
            $transaccion->save();
            DB::commit();
            $pivote = $request->data;

            foreach($pivote as $ep=>$det){
                $ep= new ProductoTransaccion();
                $ep->idTransacciones = $transaccion->idTransacciones;
                $ep->idProductos = $det['idProductos'];
                $ep->precioProductos = $det['precioProductos'];
                $ep->cantidadProductos = $det['cantidadProductos'];
                $ep->puntosProductos = $det['puntosProductos'];
                $ep->save();
            }
            DB::commit();
            }catch(Exception $e){
                DB::rollback();
            }
        

        $transaccion->save();
    }


    public function update(Request $request)
    {
        
        if(!$request->ajax()) return redirect('/');
        $validar= $request->validate([
            'descuentoTransacciones'=>'nullable|numeric|between:0,100',
            'tipoTransacciones'=>'required|not_in:0',
            'formaPagoTransacciones'=>'required|not_in:0',
            'estadoTransacciones'=>'required|not_in:0',
            'precioProductos'=>'required|min:0|not_in:0',
            'observacionTransacciones'=>'nullable|string',
        ]);
        $transaccion = Transaccion::findOrFail($request->idTransacciones);;
        $transaccion->idTransacciones = $request->input('idTransacciones');
        $transaccion->tipoTransacciones = $request->input('tipoTransacciones');
        $transaccion->observacionTransacciones = $request->input('observacionTransacciones');
        $transaccion->puntosTransacciones = $request->input('puntosTransacciones');
        $transaccion->descuentoTransacciones = $request->input('descuentoTransacciones');
        $transaccion->valorFinalTransacciones = $request->input('valorFinalTransacciones');
        $transaccion->formaPagoTransacciones = $request->input('formaPagoTransacciones');
        $transaccion->plazoTransacciones = $request->input('plazoTransacciones');
        $transaccion->estadoTransacciones = $request->input('estadoTransacciones');
        $transaccion->save();
    }
    public function selectTransaccion(Request $request){
        if(!$request->ajax()) return redirect('/');
        $transacciones = DB::table('transacciones')
        ->select('idTransacciones')->orderBy('idTransacciones', 'asc')->get();
        return ['transacciones' => $transacciones];

    }

}
