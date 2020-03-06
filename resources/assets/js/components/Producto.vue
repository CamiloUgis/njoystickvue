<template>
     <main class="main">

            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Productos
                        <button type="button" @click="abrirModal('producto', 'registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombreProductos">Nombre</option>
                                      <option value="descripcionProductos">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarProducto(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarProducto(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Descripción</th>
                                    <th class="text-center">Plataforma</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-center">Precio Nuevo</th>
                                    <th class="text-center">Precio Usado</th>
                                    <th class="text-center">Modificar</th>
                                    <th class="text-center">Asociar Género</th>

                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr v-for="producto in arrayProductos" :key="producto.idProductos">
                                    <td v-text="producto.nombreProductos"></td>
                                    <td v-text="producto.descripcionProductos"></td>
                                    <td v-text="producto.nombrePlataformas"></td>
                                    <td v-text="producto.stockProductos"></td>
                                    <td v-text="producto.precioNuevoProductos"></td>
                                    <td v-text="producto.precioUsadoProductos"></td>
                                    <td>
                                        <button type="button" @click="abrirModal('producto', 'actualizar', producto)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                    </td>
                                    <td>
                                        <button type="button" @click="abrirModal('producto', 'asociar', producto)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
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
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div v-if="tipoAccion==1 || tipoAccion==2">
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
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombreProductos" name="nombre" class="form-control" placeholder="Nombre de producto">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="descripcionProductos" name="descripcion" class="form-control" placeholder="Descripción de producto">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="number-input">Plataforma</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idPlataformas">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="plataforma in arrayPlataformas" :key="plataforma.idPlataformas"
                                            :value="plataforma.idPlataformas" v-text="plataforma.nombrePlataformas"></option>
                                        </select>
                                    </div>
                                </div>

                     
                                
                                

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="number-input">Stock</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="stockProductos" name="stock" class="form-control" placeholder="Cantidad de stock">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="number-input">Precio Nuevo</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="precioNuevoProductos" name="precionuevo" class="form-control" placeholder="Precio de juego nuevo">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="number-input">Precio Usado</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="precioUsadoProductos" name="preciousado" class="form-control" placeholder="Precio de juego usado">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()" >Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarProducto()" >Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarProducto()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            </div>
            <div v-if="tipoAccion==3">
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
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 typo__label">Géneros</label>
                                    <div class="col-md-9">
                                      <multiselect v-model="arrayGenerosSeleccionados" 
                                      placeholder="Agregue uno o más géneros" label="nombreGeneros" :hide-selected="true" 
                                      :options="arrayGeneros" :multiple="true" :taggable="true"></multiselect>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()" >Cerrar</button>
                            <button type="button" v-if="tipoAccion==3" class="btn btn-primary" @click="asociarGenero()">Asociar Género</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
import Multiselect from 'vue-multiselect'
 Vue.component('multiselect', Multiselect)

        export default {
            // OR register locally
            components: { Multiselect },   
        data(){
            return{ 
                idProductos:0,
                idPlataformas:0,
                idGeneros:0,
                nombreProductos:'',
                descripcionProductos:'',
                stockProductos:'',
                precioNuevoProductos:'',
                precioUsadoProductos:'',
                arrayProductos:[],
                modal : 0,
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
                criterio: 'nombre',
                buscar : '',
                arrayPlataformas:[],
                arrayGeneros:[],
                arrayGenerosSeleccionados:[]
                

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
            listarProducto(page, buscar, criterio){
                let me=this;
                var url= '/productos?page='+page + '&buscar='+ buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayProductos = respuesta.productos.data;
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
            selectGeneros(){
                let me=this;
                var url= '/generos/selectGeneros';
                axios.get(url).then(function (response){
                    //console.log(response);
                    var respuesta = response.data;
                    me.arrayGeneros = respuesta.generos;
                })
                .catch(function (error){
                    console.log(error.response);
                })
            },
            cambiarPagina(page, buscar, criterio){
                let me=this;
                me.pagination.current_page=page;
                me.listarProducto(page, buscar, criterio);
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
                    'stockProductos': this.stockProductos,
                    'precioNuevoProductos': this.precioNuevoProductos,
                    'precioUsadoProductos': this.precioUsadoProductos,
                    }).then(function (response){
                        me.cerrarModal();
                        me.listarProducto(1,'', 'nombre');
                        console.log(error.response);
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
            asociarGenero(){
                if(this.validarProducto()){
                    return;
                }
                let me=this;
                axios.post('productos/asociarGenero',{
                    'idProductos': this.idProductos,
                    'arrayGenerosSeleccionados': this.arrayGenerosSeleccionados,
                    }).then(function (response){
                        me.cerrarModal();
                        me.listarProducto(1,'', 'nombre');
                        console.log(error.response);
                }).catch(function (error){
                    console.log(error.response);
                })
            },
             validarProducto(){
                this.errorProducto=0;
                this.errorMsjProducto = [];
                
                if(!this.nombreProductos) this.errorMsjProducto.push("El nombre del Producto no debe estar vacío");
                if(!this.stockProductos) this.errorMsjProducto.push("El stock debe ser un número")
                if(this.errorMsjProducto.length) this.errorProducto=1;

                return this.errorProducto;
            }, 
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombreProductos='';
                this.idPlataformas=0;
                this.arrayGenerosSeleccionados=[];
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
                                this.arrayGenerosSeleccionados=[];
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
                            case 'asociar':{
                                this.modal = 1;
                                this.tipoAccion = 3;
                                this.tituloModal = "Asociar Géneros";
                                this.idProductos=data['idProductos'];
                                this.arrayGenerosSeleccionados=data['arrayGenerosSeleccionados'];                                
                                break;
                            }
                        }
                    }
                }
                this.selectGeneros();
                this.selectPlataformas();
            },
           
        },
        
        mounted() {
            this.listarProducto(1, this.buscar, this.criterio);
            
        }
    }
    

</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
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
</style>