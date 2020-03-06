<template>
     <main class="main">

            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Transacciones
                        <button type="button" @click="mostrarDetalle()" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <!-- Listado -->
                    <template v-if="listado">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="tipoTransacciones">Tipo de Transacciones</option>
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
                                    <th class="text-center">Tipo de Transacción</th>
                                    <th class="text-center">Observaciones</th>
                                    <th class="text-center">Fecha de Transacción</th>
                                    <th class="text-center">Puntos de la Transacción</th>
                                    <th class="text-center">Valor Total de la Transacción</th>
                                    <th class="text-center">Forma de Pago</th>
                                    <th class="text-center">Plazo de arriendo</th>
                                    <th class="text-center">Estado de Transacción</th>
                                    <th class="text-center">Visualizar</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr v-for="transaccion in arrayTransacciones" :key="transaccion.idTransacciones">
                                    <td v-text="transaccion.nombreClientes"></td>
                                    <td v-text="transaccion.tipoTransacciones"></td>
                                    <td v-text="transaccion.observacionTransacciones"></td>
                                    <td v-text="transaccion.fechaTransacciones"></td>
                                    <td v-text="transaccion.puntosTransacciones"></td>
                                    <td v-text="transaccion.valorFinalTransacciones"></td>
                                    <td v-text="transaccion.formaPagoTransacciones"></td>
                                    <td v-text="transaccion.plazoTransacciones"></td>
                                    <td v-text="transaccion.estadoTransacciones"></td>
                                    <td>
                                        <button type="button" @click="abrirModal('transaccion', 'actualizar', transaccion)" class="btn btn-succes btn-sm btnvisualizar">
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
                    <template v-else>
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label>Estado de Transacción</label>
                                        <select class="form-control" v-model="estadoTransacciones">
                                            <option value="0" disabled>Seleccione</option>
                                            <option value="Pagado">Pagado</option>
                                            <option value="Abonado">Abonado</option>
                                        </select>
                                    </div>
                                </div>                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo de Transacción</label>
                                    <select class="form-control" v-model="tipoTransacciones">
                                        <option value="0" disabled>Seleccione</option>
                                        <option value="Venta">Venta</option>
                                        <option value="Arriendo">Arriendo</option>
                                        <option value="Cambio">Cambio</option>
                                        <option value="Reserva">Reserva</option>
                                    </select>
                                </div>
                                
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Forma de Pago</label>
                                    <select class="form-control" v-model="formaPagoTransacciones">
                                        <option value="0" disabled>Seleccione</option>
                                        <option value="Efectivo">Efectivo</option>
                                        <option value="Débito">Débito</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                    <label for="">Observaciones</label>
                                     <input type="text" class="form-control" v-model="observacionTransacciones" placeholder="Ingrese su observación">
                                </div>
                            <div class="col-md-12">
                                    <span>AQUI VAN LAS VALIDACIONES</span>
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
                            <div class="col-md-2">
                                    <label>Precio <span style="color:red;" v-show="precioPasajeroProductos==0" >(Ingrese*)</span></label>
                                    <input type="number" value="0" class="form-control" v-model="precioPasajeroProductos">
                            </div>
                            <div class="col-md-2">
                                    <label>Cantidad<span style="color:red;" v-show="cantidadPasajeraProductos==0" >(Ingrese*) </span></label>
                                    <input type="number" value="0" class="form-control" v-model="cantidadPasajeraProductos">
                            </div>
                            <div class="col-md-3">
                                    <label>Puntos por Producto</label>
                                    <input v-model="puntosPasajeroProductos" disabled>
                                    <td>{{calcularPuntos}}</td>
                            </div>
                            <div class="col-md-9" style="margin-top:-40px;">
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
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                                <th>Puntos</th>
                                                <th>Subtotal</th>
                                                <th>Opciones</th>
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
                                                    <input v-model="detalle.cantidadProductos" type="number" value="2" class="form-control" disabled>

                                                </td>
                                                <td>
                                                    <input v-model="detalle.puntosProductos" type="number" value="2" class="form-control" disabled>

                                                </td>
                                                <td>
                                                    {{detalle.precioProductos*detalle.cantidadProductos}}
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
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" :class="{'mostrar' :modal}" role="dialog"  tabindex="-1" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                           
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()" >Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarTransaccion()" >Guardar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
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
                tipoTransacciones:0,
                observacionTransacciones:'',
                nombreProductos:'',
                nombreClientes:'',
                fechaTransacciones:'',
                puntosTransacciones:'',
                valorFinalTransacciones:'',
                precioNuevoProductos:'',
                formaPagoTransacciones:0,
                plazoTransacciones:'',
                precioNuevoProductos:'',
                precioUsadoProductos:'',
                estadoTransacciones:0,
                cantidadProductos:1,
                precioProductos:1,
                stockProductos:'',
                descuento: '',
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
                modal : 0,
                listado:1,
                tituloModal : '',
                tipoAccion : 0,
                errorProducto : 0,
                errorMsjProducto : [],
                cantidadPasajeraProductos:'',
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
                arrayPlataformas:[]

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
                for (var i=0; i<this.arrayDetalles.length;i++) {
                    parcial=(this.arrayDetalles[i].precioProductos*this.arrayDetalles[i].cantidadProductos).toFixed(0);
                    this.valorFinalTransacciones=Number(this.valorFinalTransacciones)+Number(parcial);
                }
                return this.valorFinalTransacciones;
            },
            puntosTotales: function(){
                var parcial='';
                for (var i=0; i<this.arrayDetalles.length;i++) {
                    parcial=(this.arrayDetalles[i].puntosProductos);
                    this.puntosTransacciones=Number(this.puntosTransacciones)+Number(parcial);
                }
                return this.puntosTransacciones;
            },
            calcularPuntos: function(){
                this.puntosPasajeroProductos=Number((this.precioPasajeroProductos*this.cantidadPasajeraProductos*0.01).toFixed(0));
            },
            
            
        },
        methods:{
            listarTransaccion(page, buscar, criterio){
                let me=this;
                var url= '/transacciones?page='+page + '&buscar='+ buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response){
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
                if(me.idProductos==0 || me.cantidadPasajeraProductos==0 || me.precioPasajeroProductos==0){
                }
                else{
                    if(me.encuentra(me.idProductos)){
                        Swal.fire({
                            icon: 'error',
                            title: '¡Error!',
                            text: 'Este producto ya está ingresado.'
                        })
                    }else{
                        if(me.cantidadPasajeraProductos>(me.stockProductos)){
                          Swal.fire({
                            icon: 'error',
                            title: '¡Error!',
                            text: 'No puede ingresar más que el stock existente. Stock: '+(me.stockProductos)
                        })
                    }else{
                        me.arrayDetalles.push({
                            idProductos: me.idProductos,
                            producto: me.producto,
                            cantidadProductos: me.cantidadPasajeraProductos,
                            precioProductos: me.precioPasajeroProductos,
                            puntosProductos: me.puntosPasajeroProductos,
                        });
                        me.idProductos=0;
                        me.producto='';
                        me.cantidadPasajeraProductos=1;
                        me.precioPasajeroProductos=1;
                        me.puntosPasajeroProductos=1;
                    }
                

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
            },
            
            registrarTransaccion(){

                let me=this;
                axios.post('transacciones/registrar',{
                    'idClientes': this.idClientes,
                    'tipoTransacciones': this.tipoTransacciones,
                    'observacionTransacciones': this.observacionTransacciones,    
                    'descuentoTransacciones': this.descuento,
                    'puntosTransacciones': this.puntosTransacciones,
                    'valorFinalTransacciones': this.valorFinalTransacciones,
                    'formaPagoTransacciones': this.formaPagoTransacciones,
                    'plazoTransacciones': this.plazoTransacciones,
                    'estadoTransacciones': this.estadoTransacciones,
                    'data': this.arrayDetalles
                    }).then(function (response){
                        me.listado=1;
                        me.listarTransaccion(1,'', 'idTransaccion');
                        me.idClientes=0;
                        me.tipoTransacciones='';
                        me.observacionTransacciones='';
                        me.descuentoTransacciones='';
                        me.puntosTransacciones=0;
                        me.valorFinalTransacciones=0;
                        me.formaPagoTransacciones='';
                        me.plazoTransacciones='';
                        me.estadoTransacciones='';
                        me.arrayDetalles=[];
                        me.idProductos=0;
                        me.producto='';
                        me.cantidadProductos=0;
                        me.precioProductos=0;
                        me.puntosProductos=0;
               }).catch(function(error){
                    console.log(error.response.data.errors);
                });
            },
            actualizarProducto(){
                if(this.validarProducto()){
                    return;
                }
                let me=this;
                axios.put('productos/actualizar',{
                    'nombreProductos': this.nombreProductos,
                    'idPlataformas': this.idPlataformas,
                    'descripcionProductos': this.descripcionProductos,
                    'stockProductos': this.stockProductos,
                    'precioNuevoProductos': this.precioNuevoProductos,
                    'precioUsadoProductos': this.precioUsadoProductos,
                    'idProductos': this.idProductos,
                    }).then(function (response){
                        me.cerrarModal();
                        me.listarProducto(1,'', 'nombre');
                }).catch(function (error){
                    console.log(error.response);
                })
            },

            mostrarDetalle(){
                let me=this;

                me.listado=0;
                me.idClientes=0;
                me.tipoTransacciones='';
                me.observacionTransacciones='';
                me.descuentoTransacciones='';
                me.puntosTransacciones=0;
                me.valorFinalTransacciones=0;
                me.formaPagoTransacciones='';
                me.plazoTransacciones='';
                me.estadoTransacciones='';
                me.arrayDetalles=[];
                me.idProductos=0;
                me.producto='';
                me.cantidadProductos=0;
                me.precioProductos=0;
                me.puntosProductos=0;
            },
            ocultarDetalle(){
                this.listado=1;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombreProductos='';
                this.idPlataformas=0,
                this.descripcionProductos='';
                this.stockProductos='';
                this.precioNuevoProductos='';
                this.precioUsadoProductos='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "producto":
                        {
                        switch(accion){
                            case 'registrar':{
                                this.modal = 1;
                                this.tituloModal = "Registrar Producto";
                                this.idPlataformas=0;
                                this.nombreProductos='';
                                this.descripcionProductos='';
                                this.stockProductos='';
                                this.precioNuevoProductos='';
                                this.precioUsadoProductos='';
                                this.tipoAccion = 1;
                                break;

                            }
                            case 'actualizar':{
                                this.modal = 1;
                                this.tipoAccion = 2;
                                this.tituloModal = "Actualizar Producto";
                                this.idProductos=data['idProductos'];
                                this.idPlataformas=data['idPlataformas'];
                                this.nombreProductos=data['nombreProductos'];
                                this.descripcionProductos=data['descripcionProductos'];
                                this.stockProductos=data['stockProductos'];
                                this.precioNuevoProductos=data['precioNuevoProductos'];
                                this.precioUsadoProductos=data['precioUsadoProductos'];
                                break;

                            }
                        }
                    }
                }
                //this.selectPlataformas();
            }
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
            margin-top: 2rem;
            background-color: #40c36e;
            width: 100px;
        }
        .btnvisualizar{
            background-color: #20a8d8;
            border-radius: 15px;
        }
    }
</style>
