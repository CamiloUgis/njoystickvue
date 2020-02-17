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
                                <div class="form-group">
                                    <label for="">Cliente</label>
                                    <select class="form-control">

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label for="">Descuento</label>
                                <input type="number" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo de Venta</label>
                                    <select class="form-control" v-model="tipoTransacciones">
                                        <option value="0">Seleccione</option>
                                        <option value="Venta">Venta</option>
                                        <option value="Arriendo">Arriendo</option>
                                        <option value="Cambio">Cambio</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Puntos por Transacción</label>
                                    <input type="text" class="form-control" v-model="puntosTransacciones" placeholder="150">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Forma de Pago</label>
                                    <select class="form-control" v-model="formaPagoTransacciones">
                                        <option value="0">Seleccione</option>
                                        <option value="Efectivo">Efectivo</option>
                                        <option value="Débito">Débito</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Producto</label>
                                    <div class="form-inline">
                                        <input type="text" class="form-control" v-model="idProductos" placeholder="Ingrese Producto">
                                        <button class="btn btn-primary">...</button>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Precio</label>
                                    <div class="form-inline">
                                        <input type="number" value="0" step="any" class="form-control" v-model="precioNuevoProductos">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Cantidad</label>
                                    <div class="form-inline">
                                        <input type="number" value="0" class="form-control" v-model="cantidadProductos">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <button class="btn btn-succes form-control btnagregar"><i class="icon-plus"></i></button>
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
                                                <th>Subtotal</th>
                                                <th>Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Producto X</td>
                                                <td>
                                                    <input type="number" value="3" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="number" value="2" class="form-control">
                                                </td>
                                                <td>
                                                    $6.000
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm">
                                                        <i class="icon-close"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Producto N</td>
                                                <td>
                                                    <input type="number" value="3" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="number" value="2" class="form-control">
                                                </td>
                                                <td>
                                                    $61.000
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-danger btn-sm">
                                                        <i class="icon-close"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr style="background-color: #CEECF5">
                                                <td colspan="4" align="right"> 
                                                <strong>Total Parcial:</strong>
                                                </td>
                                                <td>$1.000</td>
                                            </tr>
                                            <tr style="background-color: #CEECF5">
                                                <td colspan="4" align="right"> 
                                                <strong>Total Descuento:</strong>
                                                </td>
                                                <td>$500</td>
                                            </tr>
                                            <tr style="background-color: #CEECF5">
                                                <td colspan="4" align="right"> 
                                                <strong>Total Final:</strong>
                                                </td>
                                                <td>$500</td>
                                            </tr>
                                        </tbody>

                                </table>

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                <button type="button" class="btn btn-primary" @click="registrarIngreso()">Registrar Transacción</button>
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
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarTransaccion()">Actualizar</button>

                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
    export default {
        data(){
            return{
                idTransacciones:0,
                idProductos:0,
                tipoTransacciones:0,
                observacionTransacciones:'',
                fechaTransacciones:'',
                puntosTransacciones:'',
                valorFinalTransacciones:'',
                precioNuevoProductos:'',
                formaPagoTransacciones:0,
                plazoTransacciones:'',
                estadoTransacciones:'',
                descuento: 0.0,
                arrayTransacciones:[],
                arrayProductoTransaccion:[],
                modal : 0,
                listado:1,
                tituloModal : '',
                tipoAccion : 0,
                errorProducto : 0,
                errorMsjProducto : [],
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
            }
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
            selectPlataformas(){
                let me=this;
                var url= '/plataformas/selectPlataformas';
                axios.get(url).then(function (response){
                    //console.log(response);
                    var respuesta = response.data;
                    me.arrayPlataformas = respuesta.plataformas;
                })
                .catch(function (error){
                    console.log(error.response);
                })
            },
            cambiarPagina(page, buscar, criterio){
                let me=this;
                me.pagination.current_page=page;
                me.listarTransaccion(page, buscar, criterio);
            },
            registrarProducto(){
                if(this.validarProducto()){
                    return;
                }
                let me=this;
                axios.post('productos/registrar',{
                    'nombreProductos': this.nombreProductos,
                    'idPlataformas': this.idPlataformas,    
                    'descripcionProductos': this.descripcionProductos,
                    'stockNuevoProductos': this.stockNuevoProductos,
                    'stockUsadoProductos': this.stockUsadoProductos,
                    'precioNuevoProductos': this.precioNuevoProductos,
                    'precioUsadoProductos': this.precioUsadoProductos,
                    }).then(function (response){
                        me.cerrarModal();
                        me.listarProducto(1,'', 'nombre');
                }).catch(function (error){
                    console.log(error.response);
                })
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
                    'stockNuevoProductos': this.stockNuevoProductos,
                    'stockUsadoProductos': this.stockUsadoProductos,
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
             validarProducto(){
                this.errorProducto=0;
                this.errorMsjProducto = [];
                
               if(this.idPlataformas==0) this.errorMsjProducto.push("Seleccione una plataforma");
                if(!this.nombreProductos) this.errorMsjProducto.push("El nombre del Producto no debe estar vacío");
                if(!this.stockNuevoProductos) this.errorMsjProducto.push("El stock debe ser un número")
                if(this.errorMsjProducto.length) this.errorProducto=1;

                return this.errorProducto;
            },
            mostrarDetalle(){
                this.listado=0;
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
                this.stockNuevoProductos='';
                this.stockUsadoProductos='';
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
                                this.stockNuevoProductos='';
                                this.stockUsadoProductos='';
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
                                this.stockNuevoProductos=data['stockNuevoProductos'];
                                this.stockUsadoProductos=data['stockUsadoProductos'];
                                this.precioNuevoProductos=data['precioNuevoProductos'];
                                this.precioUsadoProductos=data['precioUsadoProductos'];
                                break;

                            }
                        }
                    }
                }
                this.selectPlataformas();
            }
        },
        
        mounted() {
            this.listarTransaccion(1, this.buscar, this.criterio);
        }
    }
</script>
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
        }
        .btnvisualizar{
            background-color: #20a8d8;
            border-radius: 15px;
        }
    }
</style>