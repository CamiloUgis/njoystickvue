<template>
     <main class="main">

            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Reserva
                        <button type="button" @click="mostrarDetalle()" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <!-- Listado -->
                    <template v-if="listado==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="formaPagoTransacciones">Forma de Pago</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarTransaccion(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarTransaccion(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center">Cliente</th>
                                    <th class="text-center">Fecha de Transacción</th>
                                    <th class="text-center">Producto</th>
                                    <th class="text-center">Valor Producto</th>
                                    <th class="text-center">Valor Abonado</th>
                                    <th class="text-center">Por Pagar</th>
                                    <th class="text-center">Forma de Pago</th>
                                    <th class="text-center">Visualizar</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr v-for="transaccion in arrayTransacciones" :key="transaccion.idTransacciones">
                                    <td v-text="transaccion.nombreClientes"></td>
                                    <td v-text="transaccion.fechaTransacciones"></td>
                                    <td v-text="transaccion.nombreProductos"></td>
                                    <td v-text="transaccion.precioNuevoProductos"></td>
                                    <td v-text="transaccion.abonoClienteProducto"></td>
                                    <td v-text="transaccion.valorFinalTransacciones"></td>
                                    <td v-text="transaccion.formaPagoTransacciones"></td>
                                    <td>
                                        <button type="button" @click="verTransaccion(transaccion.idTransacciones)" class="btn btn-succes btn-sm btnvisualizar">
                                          <i class="icon-eye"></i>
                                        </button> &nbsp;
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </div>
                        <nav>
                            <ul class="pagination">
                                <li class = "page-item" v-if="pagination.current_page>1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page -1, buscar, criterio)"> Ant</a>
                                
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)" v-text="page"></a>
                                </li>
                                
                                <li class = "page-item" v-if="pagination.current_page< pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1, buscar, criterio)"> Sig</a>
                                
                                </li>
                            </ul>
                        </nav>
                    </div>
                    </template>
                    <!-- Fin Listado -->

                    <!-- Detalle-->
                    <template v-else-if="listado==0">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-9">
                                <div class="form-group" id="cli">
                                    <label for="">Cliente</label>
                                    <v-select
                                        @search="transaccionClientes"
                                        label="nombreClientes"
                                        :options="arrayClientes"
                                        placeholder="Buscar Clientes..."
                                        @input="getDatosClientes"
                                    >
                                    </v-select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="">Descuento (en %)</label>
                                <input type="number" class="form-control" v-model="descuento" placeholder="5%">
                            </div>
                                <div class="col-md-3" style="margin-top:20px;">
                                    <div class="form-group">
                                    <label>Estado de Transacción</label> 
                                    <input v-model="estadoTransacciones" disabled>
                                    </div>
                                </div>                            
                            <div class="col-md-3" style="margin-top:20px;">
                                <div class="form-group">
                                    <label>Tipo de Transacción</label>
                                    <input v-model="tipoTransacciones" disabled>
                                </div>
                                
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Forma de Pago</label>
                                    <select class="form-control" v-model="formaPagoTransacciones">
                                        <option value="0" disabled>Seleccione</option>
                                        <option value="Efectivo">Efectivo</option>
                                        <option value="Débito">Débito</option>
                                        <option value="Crédito">Crédito</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-bottom: 15px;">
                                    <label for="">Observaciones</label>
                                     <input type="text" class="form-control" v-model="observacionTransacciones" placeholder="Ingrese su observación">
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Producto <span style="color:red;" v-show="idProductos==0" >(Ingrese*)</span></label>
                                    <v-select
                                        @search="transaccionProducto"
                                        label="nombreProductos"
                                        :options="arrayProductos"
                                        placeholder="Buscar Productos..."
                                        @input="getDatosProductos"
                                    > 
                                    </v-select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="col-md-2" style="margin-bottom: 15px;">
                                    <label>Precio Producto<span style="color:red;" v-show="precioPasajeroProductos==0" >(Ingrese*)</span></label>
                                    <input type="number" value="0" class="form-control" v-model="precioPasajeroProductos">
                            </div>
                            <div class="col-md-2">
                                    <label>Precio Abonado<span style="color:red;" v-show="AbonadoPasajeroProductos==0" >(Ingrese*) </span></label>
                                    <input type="number" value="0" class="form-control" v-model="AbonadoPasajeroProductos">
                            </div>
                            <div class="col-md-4" style="margin-top: 30px;">
                                    <label>Puntos por Producto</label>
                                    <input v-model="puntosPasajeroProductos" disabled>
                                    <td>{{calcularPuntos}}</td>
                            </div>
                            <div class="col-md-3" style="margin-top:25px">
                                <div class="form-group">
                                    <button @click="agregarDetalle" class="btn btn-succes form-control btnagregar float-right"><i class="icon-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12" style="margin-top: 15px;">
                                <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Precio Producto</th>
                                                <th>Precio Abonado</th>
                                                <th>Puntos</th>
                                                <th>Subtotal</th>
                                                <th>Eliminar</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="arrayDetalles.length">
                                            <tr v-for="(detalle,index) in arrayDetalles" :key="detalle.idDetalle">
                                                <td v-text="detalle.producto">
                                                </td>
                                                
                                                <td>
                                                    <input v-model="detalle.precioProductos" type="number" value="3" class="form-control" disabled>
                                                </td>
                                                <td>
                                                    <input v-model="detalle.abonoClienteProducto" type="number" value="2" class="form-control" disabled>

                                                </td>
                                                <td>
                                                    <input v-model="detalle.puntosProductos" type="number" value="2" class="form-control" disabled>

                                                </td>
                                                <td>
                                                    {{detalle.precioProductos-detalle.abonoClienteProducto}}
                                                </td>
                                                <td>
                                                    <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                                        <i class="icon-close"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr style="background-color: #CEECF5">
                                                <td colspan="4" align="right"> 
                                                <strong>Total Parcial:</strong>
                                                </td>
                                                <td>${{totalParcial=(calcularTotal)}}</td>
                                            </tr>
                                            <tr style="background-color: #CEECF5">
                                                <td colspan="4" align="right"> 
                                                <strong>Total Descuento:</strong>
                                                </td>
                                                <td>$ {{totalDescuento=(totalParcial*(descuento/100)).toFixed(0)}}</td>
                                            </tr>
                                            <tr style="background-color: #CEECF5">
                                                <td colspan="4" align="right"> 
                                                <strong>Total Final:</strong>
                                                </td>
                                                <td>$ {{total=(calcularTotal-totalDescuento).toFixed(0)}}</td>
                                            </tr>
                                            <tr style="background-color: #CEECF5">
                                                <td colspan="4" align="right"> 
                                                <strong>Puntos totales:</strong>
                                                </td>
                                                <td>{{puntosTotales}}</td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="5"> 
                                                   <center><span> NO hay productos agregados.</span></center>
                                                </td>
                                            </tr>

                                        </tbody>

                                </table>

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                <button type="button" class="btn btn-primary" @click="registrarTransaccion()">Registrar Transacción</button>
                            </div>

                        </div>
                    </div>
                    </template>
                    <!-- Fin Detalle-->
                    <!-- Ver ingreso -->
                    <template v-else-if="listado==2">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="">Cliente</label>
                                    <p v-text="nombreClientes"></p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="">Descuento</label>
                                <p v-text="descuentoTransacciones">%</p>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Estado de transacción</label>
                                    <p v-text="estadoTransacciones"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo de Transacción</label>
                                    <p v-text="tipoTransacciones"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Forma de Pago</label>
                                    <p v-text="formaPagoTransacciones"></p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Observaciones</label>
                                    <p v-text="observacionTransacciones"></p>
                                </div>

                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Producto</th>
                                            <th>Precio Producto</th>
                                            <th>Precio Abonado</th>
                                            <th>Puntos</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayDetalles.length">
                                        <tr v-for="detalle in arrayDetalles" :key="detalle.id">
                                            <td v-text="detalle.nombreProductos">
                                            </td>
                                            <td v-text="detalle.precioProductos">
                                            </td>
                                            <td v-text="detalle.abonoClienteProducto">
                                            </td>
                                            <td v-text="detalle.puntosProductos">
                                            </td>
                                            <td>
                                                {{detalle.precioProductos-detalle.abonoClienteProducto}}
                                            </td>
                                        </tr>
                                        <tr style="background-color: #CEECF5">
                                                <td colspan="4" align="right"> 
                                                <strong>Total Parcial:</strong>
                                                </td>
                                                <td>${{totalParcial=(calcularTotal)}}</td>
                                            </tr>
                                            <tr style="background-color: #CEECF5">
                                                <td colspan="4" align="right"> 
                                                <strong>Total Descuento:</strong>
                                                </td>
                                                <td>$ {{totalDescuento=(totalParcial*(descuento/100)).toFixed(0)}}</td>
                                            </tr>
                                            <tr style="background-color: #CEECF5">
                                                <td colspan="4" align="right"> 
                                                <strong>Total Final:</strong>
                                                </td>
                                                <td>$ {{total=(calcularTotal-totalDescuento).toFixed(0)}}</td>
                                            </tr>
                                            <tr style="background-color: #CEECF5">
                                                <td colspan="4" align="right"> 
                                                <strong>Puntos totales:</strong>
                                                </td>
                                                <td>{{puntosTotales}}</td>
                                            </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">
                                              <center>  NO hay artículos agregados </center>
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                
                            </div>
                        </div>
                    </div>
                    </template>
                    <!-- fin ver ingreso -->
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            
        </main>
</template>
<script src="https://unpkg.com/vue@latest"></script>
<script src="https://unpkg.com/vue-select@latest"></script>
<script src="sweetalert2.all.min.js"></script>
<script src="sweetalert2.min.js"></script>

<script>
import Vue from 'vue'
import vSelect from 'vue-select'
// ES6 Modules or TypeScript
import Swal from 'sweetalert2'

// CommonJS

Vue.component('v-select', vSelect)


    export default {
        data(){
            return{
                idTransacciones:0,
                idProductos:0,
                idClientes:0,
                tipoTransacciones:'Reserva',
                observacionTransacciones:'',
                nombreProductos:'',
                nombreClientes:'',
                fechaTransacciones:'',
                puntosTransacciones:'',
                descuentoTransacciones:'',
                valorFinalTransacciones:'',
                precioNuevoProductos:'',
                formaPagoTransacciones:0,
                plazoTransacciones:'',
                precioNuevoProductos:'',
                precioUsadoProductos:'',
                estadoTransacciones:'Abonado',
                cantidadProductos:0,
                precioProductos:0,
                stockProductos:'',
                abonoClienteProducto:'',
                descuento:0,
                total:0.0,
                totalDescuento:0.0,
                totalParcial:0,
                arrayTransacciones:[],
                arrayProductoTransaccion:[],
                arrayClientes:[],
                arrayProductos:[],
                arrayDetalles:[],
                arrayPrecioStock:[],
                producto:'',
                puntosProductos:'',
                listado:1,
                arrayTransaccionT:[],
                AbonadoPasajeroProductos:'',
                precioPasajeroProductos:'',
                puntosPasajeroProductos:'',
                pagination : {
                'total' :0 ,
                'current_page':0 ,
                'per_page': 0,
                'last_page': 0,
                'from': 0,
                'to': 0,
                },
                offset: 3,
                criterio: 'tipoTransaccion',
                buscar : '',
                arrayPlataformas:[],

            }
        },
        component:{
            vSelect
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            pagesNumber: function(){
                if(!this.pagination.to){
                    return [];
                }

                var from= this.pagination.current_page - this.offset;
                if(from<1){
                    from = 1;
                }

                var to = from + (this.offset*2);
                if(to>=this.pagination.last_page){
                    to=this.pagination.last_page;
                }
                var pagesArray = [];
                while(from<=to){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
            calcularTotal: function(){
                var parcial='';
                this.valorFinalTransacciones=0;
                for (var i=0; i<this.arrayDetalles.length;i++) {
                    parcial=(this.arrayDetalles[i].precioProductos-this.arrayDetalles[i].abonoClienteProducto).toFixed(0);
                    this.valorFinalTransacciones=Number(this.valorFinalTransacciones)+Number(parcial);
                }
                return this.valorFinalTransacciones;
            },
            puntosTotales: function(){
                var parcial='';
                this.puntosTransacciones=0;
                for (var i=0; i<this.arrayDetalles.length;i++) {
                    parcial=(this.arrayDetalles[i].puntosProductos);
                    this.puntosTransacciones=Number(this.puntosTransacciones)+Number(parcial);
                }
                return this.puntosTransacciones;
            },
            calcularPuntos: function(){
                this.puntosPasajeroProductos=Number(((this.precioPasajeroProductos-this.AbonadoPasajeroProductos)*0.01).toFixed(0));
            }, 
        },
        methods:{
            listarTransaccion(page, buscar, criterio){
                let me=this;
                var url= '/transaccionesReservas?page='+page + '&buscar='+ buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response){
                    console.log(response.data);
                    var respuesta = response.data;
                    me.arrayTransacciones = respuesta.transacciones.data;
                    me.pagination=respuesta.pagination;
                })
                .catch(function (error){
                    console.log(error.response);
                })
            },
            
            transaccionClientes(search,loading){
                let me=this;
                loading(true)
                var url= '/clientes/transaccionClientes?filtro='+search;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    q: search
                    me.arrayClientes=respuesta.clientes;
                    loading(false)
                })
                .catch(function (error){
                    console.log(error.response);
                })
            },
            getDatosClientes(val1){
                let me=this;
                me.loading = true;
                me.idClientes = val1.idClientes;
            },
            cambiarPagina(page, buscar, criterio){
                let me=this;
                me.pagination.current_page=page;
                me.listarTransaccion(page, buscar, criterio);
            },
            encuentra(id){
                var sw=0;
                for (var i=0; i<this.arrayDetalles.length;i++){
                    if(this.arrayDetalles[i].idProductos==id){
                        sw=true;
                    }

                }
                return sw;
            },
            eliminarDetalle(index){
                let me = this;
                me.arrayDetalles.splice(index, 1);
            },           
            agregarDetalle(){
                let me=this;
                const Swal = require('sweetalert2')
                if(me.idProductos==0 || me.AbonadoPasajeroProductos==0 || me.precioPasajeroProductos==0){
                }
                else{
                    if(me.encuentra(me.idProductos)){
                        Swal.fire({
                            icon: 'error',
                            title: '¡Error!',
                            text: 'Este producto ya está ingresado.'
                        })
                    }else{
                        // if(me.cantidadPasajeraProductos>(me.stockProductos)){
                        //     Swal.fire({
                        //         icon: 'error',
                        //         title: '¡Error!',
                        //         text: 'No puede ingresar más que el stock existente. Stock: '+(me.stockProductos)
                        //     })
                        // }else{
                            me.arrayDetalles.push({
                                idProductos: me.idProductos,
                                producto: me.producto,
                                abonoClienteProducto: me.AbonadoPasajeroProductos,
                                precioProductos: me.precioPasajeroProductos,
                                puntosProductos: me.puntosPasajeroProductos,

                            });
                            me.idProductos=0;
                            me.producto='';
                            me.AbonadoPasajeroProductos=0;
                            me.precioPasajeroProductos=0;
                            me.puntosPasajeroProductos=0;
                        }
                }             
            },
            transaccionProducto(search,loading){
                let me=this;
                loading(true)
                var url= '/productos/transaccionProducto?filtro='+search;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    q: search
                    me.arrayProductos=respuesta.productos;
                    loading(false)
                })
                .catch(function (error){
                    console.log(error.response);
                })
            },
            getDatosProductos(val1){
                let me=this;
                me.loading = true;
                me.idProductos = val1.idProductos;
                me.producto = val1.nombreProductos;
                me.precioNuevoProductos= val1.precioNuevoProductos;
                me.precioUsadoProductos=val1.precioUsadoProductos;
                me.stockProductos=val1.stockProductos;
                me.precioPasajeroProductos=val1.precioNuevoProductos;                
            },
            
            registrarTransaccion(){

                let me=this;
                axios.post('transacciones/registrarReserva',{
                    'idClientes': this.idClientes,
                    'tipoTransacciones': this.tipoTransacciones,
                    'observacionTransacciones': this.observacionTransacciones,    
                    'descuentoTransacciones': this.descuento,
                    'puntosTransacciones': this.puntosTransacciones,
                    'valorFinalTransacciones': this.valorFinalTransacciones,
                    'formaPagoTransacciones': this.formaPagoTransacciones,
                    'plazoTransacciones': this.plazoTransacciones,
                    'estadoTransacciones': this.estadoTransacciones,
                    'abonoClienteProducto': this.abonoClienteProducto,
                    'data': this.arrayDetalles
                    }).then(function (response){
                        me.listado=1;
                        me.listarTransaccion(1,'', 'idTransacciones');
                        me.idClientes=0;
                        me.tipoTransacciones='Reserva';
                        me.observacionTransacciones='';
                        me.descuentoTransacciones='';
                        me.puntosTransacciones=0;
                        me.valorFinalTransacciones=0;
                        me.formaPagoTransacciones='';
                        me.plazoTransacciones='';
                        me.estadoTransacciones='Abonado';
                        me.arrayDetalles=[];
                        me.idProductos=0;
                        me.producto='';
                        me.cantidadProductos=0;
                        me.precioProductos=0;
                        me.puntosProductos=0;
                        me.abonoClienteProducto=0;
               }).catch(function(error){
                    console.log(error.response.data.errors);
                });
            },
            mostrarDetalle(){
                let me=this;
                me.abonoClienteProducto=0;
                me.listado=0;
                me.idClientes=0;
                me.tipoTransacciones='Reserva';
                me.observacionTransacciones='';
                me.descuentoTransacciones='';
                me.puntosTransacciones=0;
                me.valorFinalTransacciones=0;
                me.formaPagoTransacciones='';
                me.plazoTransacciones='';
                me.estadoTransacciones='Abonado';
                me.arrayDetalles=[];
                me.idProductos=0;
                me.producto='';
                me.cantidadProductos=0;
                me.precioProductos=0;
                me.puntosProductos=0;
            },
            ocultarDetalle(){
                this.listado=1;
                this.totalParcial=0;
                this.total=0;
                this.totalDescuento=0;
                this.valorFinalTransacciones=0;
                this.descuento=0;
            },
            verTransaccion(idTransacciones){
                let me=this;
                me.listado=2;
                
                //Obtener los datos del ingreso
                var arrayTransaccionT=[];
                var url= '/transacciones/obtenerCabecera?idTransacciones=' + idTransacciones;
                
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayTransaccionT = respuesta.transacciones;

                    me.nombreClientes = arrayTransaccionT[0]['nombreClientes'];
                    me.descuentoTransacciones=arrayTransaccionT[0]['descuentoTransacciones'];
                    me.estadoTransacciones=arrayTransaccionT[0]['estadoTransacciones'];
                    me.tipoTransacciones=arrayTransaccionT[0]['tipoTransacciones'];
                    me.formaPagoTransacciones=arrayTransaccionT[0]['formaPagoTransacciones'];
                    me.observacionTransacciones=arrayTransaccionT[0]['observacionTransacciones'];
                    me.puntosTransacciones=arrayTransaccionT[0]['puntosTransacciones'];
                    me.valorFinalTransacciones=arrayTransaccionT[0]['valorFinalTransacciones'];
                    me.abonoClienteProducto=arrayTransaccionT[0]['abonoClienteProducto'];
                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener los datos de los detalles 
                var urld= '/transacciones/obtenerDetalles?idTransacciones=' + idTransacciones;
                
                axios.get(urld).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arrayDetalles = respuesta.detalles;
                })
                .catch(function (error) {
                    console.log(error);
                });               
            },
    
        },
        
        mounted() {
            this.listarTransaccion(1, this.buscar, this.criterio);
        }
    }
</script>
<style src="vue-select/dist/vue-select.css"></style>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }

    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    @media (min-width:600px){
        .btnagregar{
            background-color: #40c36e;
            width: 100px;
        }
        .btnvisualizar{
            background-color: #20a8d8;
            border-radius: 15px;
        }
    }
</style>
