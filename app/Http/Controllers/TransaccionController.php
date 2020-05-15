<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Transaccion;
use App\Socio;
use App\Cliente;
use App\Producto;
use App\ProductoTransaccion;
use App\ClienteProducto;

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
        if(!$request->ajax()) return redirect('/');
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
            ->orderBy('producto_transaccion.idTransacciones', 'desc')
            ->groupby('producto_transaccion.idTransacciones')->paginate(8);

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
            ->orderBy('producto_transaccion.idTransacciones', 'desc')
            ->groupby('producto_transaccion.idTransacciones')->paginate(8);              
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
            $transaccion->fechaTransacciones = $mytime;
            $transaccion->observacionTransacciones = $request->input('observacionTransacciones');
            $transaccion->puntosTransacciones = $request->input('puntosTransacciones');
            $transaccion->puntosGastadosTransacciones=0;
            $transaccion->descuentoTransacciones = $request->input('descuentoTransacciones');
            $transaccion->valorFinalTransacciones = $request->input('valorFinalTransacciones');
            $transaccion->formaPagoTransacciones = $request->input('formaPagoTransacciones');
            $transaccion->plazoTransacciones = $request->input('plazoTransacciones');
            $transaccion->estadoTransacciones = $request->input('estadoTransacciones');
            $transaccion->idClientes = $request->input('idClientes');
            $transaccion->save();
            DB::commit();
            $socio1=Socio::where('idClientes', '=', $request->input('idClientes'));
            $socio1->decrement('puntosActualesSocios',500);
            
            $socio1->increment('puntosPropiosSocios',$request->input('puntosTransacciones'));
            $socio1->increment('puntosActualesSocios',$request->input('puntosTransacciones'));
           
            if(!($request->input('idClientes')==99)){
            $socio=Socio::where('idClientes', '=', $request->input('idClientes'))->select('invitador')->first();
            $invitador=Socio::where('idClientes', $socio->invitador)->first();
            $invitador->increment('puntosReferidosSocios', ( $request->input('puntosTransacciones'))/2);
            $invitador->increment('puntosActualesSocios', ( $request->input('puntosTransacciones'))/2);
            $invitador->save();       
            }
            $pivote = $request->data;

            foreach($pivote as $cp=>$test){
                $cp= new ClienteProducto();
                $cp->idClientes = $transaccion->idClientes;
                $cp->idProductos = $test['idProductos'];
                $cp->abonoClienteProducto = '0';
                $cp->save();
            }
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
    public function obtenerCabecera(Request $request){
        if (!$request->ajax()) return redirect('/');

        $idTransacciones = $request->idTransacciones;
        $transacciones = Transaccion::join('clientes','transacciones.idClientes','=','clientes.idClientes')
        ->select('transacciones.idTransacciones','transacciones.descuentoTransacciones','transacciones.estadoTransacciones','transacciones.tipoTransacciones',
        'transacciones.formaPagoTransacciones','transacciones.fechaTransacciones','transacciones.valorFinalTransacciones',
        'transacciones.observacionTransacciones','clientes.idClientes','clientes.nombreClientes')
        ->where('transacciones.idTransacciones','=',$idTransacciones)
        ->orderBy('transacciones.idTransacciones', 'desc')->take(1)->get();
        
        return ['transacciones' => $transacciones];
    }
    public function obtenerDetalles(Request $request){
        if (!$request->ajax()) return redirect('/');

        $idTransacciones = $request->idTransacciones;
        $detalles = ProductoTransaccion::join('productos','producto_transaccion.idProductos','=','productos.idProductos')
        ->join('cliente_producto', 'productos.idProductos','=', 'cliente_producto.idProductos')
        ->select('producto_transaccion.precioProductos','producto_transaccion.cantidadProductos','producto_transaccion.puntosProductos',
        'productos.nombreProductos', 'productos.idProductos', 'cliente_producto.abonoClienteProducto', 'cliente_producto.idClientes')
        ->where('producto_transaccion.idTransacciones','=',$idTransacciones)
        ->orderBy('producto_transaccion.idTransacciones', 'desc')->get();
        
        return ['detalles' => $detalles];
    }
    public function indexVentas(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
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
            ->where('transacciones.tipoTransacciones','=','Venta')
            ->orderBy('producto_transaccion.idTransacciones', 'desc')
            ->groupby('producto_transaccion.idTransacciones')->paginate(8);


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
            ->where('transacciones.tipoTransacciones','=','Venta')
            ->orderBy('producto_transaccion.idTransacciones', 'desc')
            ->groupby('producto_transaccion.idTransacciones')->paginate(8);
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
    public function indexArriendos(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
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
            ->where('transacciones.tipoTransacciones','=','Arriendo')
            ->orderBy('producto_transaccion.idTransacciones', 'desc')
            ->groupby('producto_transaccion.idTransacciones')->paginate(8);

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
            ->where('transacciones.tipoTransacciones','=','Arriendo')
            ->orderBy('producto_transaccion.idTransacciones', 'desc')
            ->groupby('producto_transaccion.idTransacciones')->paginate(8);
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
    public function indexCanjes(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
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
            ->where('transacciones.tipoTransacciones','=','Canje')
            ->orderBy('producto_transaccion.idTransacciones', 'desc')
            ->groupby('producto_transaccion.idTransacciones')->paginate(8);

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
            ->where('transacciones.tipoTransacciones','=','Canje')
            ->orderBy('producto_transaccion.idTransacciones', 'desc')
            ->groupby('producto_transaccion.idTransacciones')->paginate(8);            
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
    public function indexReservas(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $buscar= $request->buscar;
        $criterio = $request->criterio;
        if($buscar==''){
            $transacciones = Transaccion::join('clientes','transacciones.idClientes','=','clientes.idClientes')
            ->join('producto_transaccion', 'transacciones.idTransacciones', '=', 'producto_transaccion.idTransacciones')
            ->join('productos', 'producto_transaccion.idProductos','=','productos.idProductos')
            ->join('cliente_producto', 'clientes.idClientes','=', 'cliente_producto.idClientes')
            ->select('transacciones.tipoTransacciones', 'transacciones.observacionTransacciones', 'transacciones.fechaTransacciones', 
            'transacciones.puntosTransacciones', 'transacciones.descuentoTransacciones', 'transacciones.valorFinalTransacciones', 'transacciones.formaPagoTransacciones',
            'transacciones.plazoTransacciones', 'transacciones.estadoTransacciones', 'clientes.nombreClientes', 'clientes.rutClientes', 
            'producto_transaccion.idTransacciones', 'productos.nombreProductos', 'productos.stockProductos',
            'productos.precioNuevoProductos', 'productos.precioUsadoProductos', 'cliente_producto.abonoClienteProducto')
            ->where('transacciones.tipoTransacciones','=','Reserva')
            ->orderBy('producto_transaccion.idTransacciones', 'desc')
            ->groupby('producto_transaccion.idTransacciones')->paginate(8);

        }else{
            $transacciones = Transaccion::join('clientes','transacciones.idClientes','=','clientes.idClientes')
            ->join('producto_transaccion', 'transacciones.idTransacciones', '=', 'producto_transaccion.idTransacciones')
            ->join('productos', 'producto_transaccion.idProductos','=','productos.idProductos')
            ->join('cliente_producto', 'clientes.idClientes','=', 'cliente_producto.idClientes')
            ->select('transacciones.tipoTransacciones', 'transacciones.observacionTransacciones', 'transacciones.fechaTransacciones', 
            'transacciones.puntosTransacciones', 'transacciones.descuentoTransacciones', 'transacciones.valorFinalTransacciones', 'transacciones.formaPagoTransacciones',
            'transacciones.plazoTransacciones', 'transacciones.estadoTransacciones', 'clientes.nombreClientes', 'clientes.rutClientes', 
            'producto_transaccion.idTransacciones', 'productos.nombreProductos', 'productos.stockProductos',
            'productos.precioNuevoProductos', 'productos.precioUsadoProductos', 'cliente_producto.abonoClienteProducto')
            ->where('transacciones.'.$criterio, 'like', '%'. $buscar . '%')
            ->where('transacciones.tipoTransacciones','=','Reserva')
            ->orderBy('producto_transaccion.idTransacciones', 'desc')
            ->groupby('producto_transaccion.idTransacciones')->paginate(8);            
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
    public function recomendar(Request $request){
        if (!$request->ajax()) return redirect('/');
        //obtener la lista de transacciones
        $idProductos=$request->idProductos;
        $compra=$request->idProductos;
        $recomendados=DB::select( 
         DB::raw("(SELECT pt.idProductos, p.nombreProductos, count(*)
          from producto_transaccion as pt 
          join productos as p on pt.idProductos = p.idProductos
           where pt.idTransacciones in
         (SELECT pt.idTransacciones from producto_transaccion
         as pt join transacciones as t
         on t.idTransacciones = pt.idTransacciones 
         where pt.idProductos = :idProductos group by pt.idTransacciones)
         and pt.idProductos <> :compra group by pt.idProductos LIMIT 3)"), array(
            'idProductos' => $idProductos, 'compra'=>$compra,));
        // $transacciones=DB::table('producto_transaccion')
        // ->join('productos','productos.idProductos', '=', 'producto_transaccion.idProductos')
        // ->select('producto_transaccion.idTransacciones')
        // ->where('producto_transaccion.idProductos','=', $idProductos)->get();
        // $pSimilares=DB::table('producto_transaccion')
        // ->join($transacciones, $transacciones.'idTransacciones', '=', 'productos_transacciones.idTransacciones')
        // ->join('producto', 'producto_transaccion.idProductos','=','producto.idProductos')
        // ->select('producto_transaccion.idProductos', 'producto.nombreProductos', 'count(*)')
        // ->where('transacciones.idTransacciones', "=", $transacciones.'idTransacciones')
        // ->where('transacciones.idProducto', "!=", $idProductos)
        // ->groupBy("producto.idProductos")->limit(3)->get();


        return ['recomendados'=>$recomendados];
    }


    public function registrarReserva(Request $request)
    {

        if(!$request->ajax()) return redirect('/');
        try{
            DB::beginTransaction();
            $mytime= Carbon::now('America/Santiago');
            $transaccion = new Transaccion();
            $transaccion->idTransacciones = $request->input('idTransacciones');
            $transaccion->tipoTransacciones = $request->input('tipoTransacciones');
            $transaccion->fechaTransacciones = $mytime;
            $transaccion->observacionTransacciones = $request->input('observacionTransacciones');
            $transaccion->puntosTransacciones = $request->input('puntosTransacciones');
            $transaccion->puntosGastadosTransacciones=0;
            $transaccion->descuentoTransacciones = $request->input('descuentoTransacciones');
            $transaccion->valorFinalTransacciones = $request->input('valorFinalTransacciones');
            $transaccion->formaPagoTransacciones = $request->input('formaPagoTransacciones');
            $transaccion->plazoTransacciones = '0000-00-00';
            $transaccion->estadoTransacciones = $request->input('estadoTransacciones');
            $transaccion->idClientes = $request->input('idClientes');
            $transaccion->save();
            DB::commit();
            $socio1=Socio::where('idClientes', '=', $request->input('idClientes'));
            $socio1->decrement('puntosActualesSocios',500);
            
            $socio1->increment('puntosPropiosSocios',$request->input('puntosTransacciones'));
            $socio1->increment('puntosActualesSocios',$request->input('puntosTransacciones'));
           
            if(!($request->input('idClientes')==99)){
                $socio=Socio::where('idClientes', '=', $request->input('idClientes'))->select('invitador')->first();
                $invitador=Socio::where('idClientes', $socio->invitador)->first();
                $invitador->increment('puntosReferidosSocios', ( $request->input('puntosTransacciones'))/2);
                $invitador->increment('puntosActualesSocios', ( $request->input('puntosTransacciones'))/2);
                $invitador->save();       
            }
            $pivote = $request->data;

            foreach($pivote as $cp=>$test){
                $cp= new ClienteProducto();
                $cp->idClientes = $transaccion->idClientes;
                $cp->idProductos = $test['idProductos'];
                $cp->abonoClienteProducto = $test['abonoClienteProducto'];
                $cp->save();
            }
            foreach($pivote as $ep=>$det){
                $ep= new ProductoTransaccion();
                $ep->idTransacciones = $transaccion->idTransacciones;
                $ep->idProductos = $det['idProductos'];
                $ep->precioProductos = $det['precioProductos'];
                $ep->cantidadProductos =1;
                $ep->puntosProductos = $det['puntosProductos'];
                $ep->save();
            }
            
            DB::commit();
            }catch(Exception $e){
                DB::rollback();
            }
        

        $transaccion->save();
    }


}
