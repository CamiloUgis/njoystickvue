<template>
     <main class="main">

            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Plataformas
                        <button type="button" @click="abrirModal('plataforma', 'registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombrePlataformas">Nombre</option>
                                      <option value="descripcionPlataformas">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarPlataforma(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarPlataforma(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Descripción</th>
                                    <th class="text-center">Cantidad de juegos</th>
                                    <th class="text-center">Modificar</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr v-for="plataforma in arrayPlataformas" :key="plataforma.idPlataformas">
                                    <td v-text="plataforma.nombrePlataformas"></td>
                                    <td v-text="plataforma.descripcionPlataformas"></td>
                                    <td v-text="plataforma.cantidadPlataformas"></td>


                                    <td>
                                        <button type="button" @click="abrirModal('plataforma', 'actualizar', plataforma)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                                        <input type="text" v-model="nombrePlataformas" name="nombre" class="form-control" placeholder="Nombre de plataforma">
                                        <span v-if="errors.nombrePlataformas" class="error">{{errors.nombrePlataformas[0]}}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="descripcionPlataformas" name="descripcion" class="form-control" placeholder="Descripción de plataforma">
                                    </div>
                                </div>
                                <!-- <div v-show="errorPlataforma" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMsjPlataforma" :key="error" v-text="error"></div>
                                    </div>
                                </div> -->
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()" >Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarPlataforma()" >Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPlataforma()">Actualizar</button>

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
import { required, minLength, between } from 'vuelidate/lib/validators'
    export default {
        data(){
            return{
                idPlataformas:'0',
                nombrePlataformas:'',
                descripcionPlataformas:'',
                arrayPlataformas:[],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errors: [],
                // errorPlataforma : 0,
                // errorMsjPlataforma : [],
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
                buscar : ''

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
            listarPlataforma(page, buscar, criterio){
                let me=this;
                var url= '/plataformas?page='+page + '&buscar='+ buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayPlataformas = respuesta.plataformas.data;
                    me.pagination=respuesta.pagination;
                })
                .catch(function (error){
                    console.log(error);
                })
            },
            cambiarPagina(page, buscar, criterio){
                let me=this;
                me.pagination.current_page=page;
                me.listarPlataforma(page, buscar, criterio);
            },
            registrarPlataforma(){
                // if(this.validarPlataforma()){
                //     return;
                // }
                this.errors =[]

                let me=this;
                axios.post('plataformas/registrar',{
                    'nombrePlataformas': this.nombrePlataformas,
                    'descripcionPlataformas': this.descripcionPlataformas
                    }).then(function (response){
                        me.cerrarModal();
                        me.listarPlataforma(1,'', 'nombre');
                }).catch(error=>{
                    if(error.response.status == 422){
                        this.errors = error.response.data.errors
                    }
                })
            },
            actualizarPlataforma(){
                // if(this.validarPlataforma()){
                //     return;
                // }
                let me=this;
                axios.put('plataformas/actualizar',{
                    'nombrePlataformas': this.nombrePlataformas,
                    'descripcionPlataformas': this.descripcionPlataformas,
                    'idPlataformas': this.idPlataformas
                    }).then(function (response){
                        me.cerrarModal();
                        me.listarPlataforma(1,'', 'nombre');
                }).catch(error=>{
                    if(error.response.status == 422){
                        this.errors = error.response.data.errors
                    }
                })
            },
            // validarPlataforma(){
            //     this.errorPlataforma=0;
            //     this.errorMsjPlataforma = [];

            //     if(!this.nombrePlataformas) this.errorMsjPlataforma.push("El nombre de la plataforma no debe estar vacío");

            //     if(this.errorMsjPlataforma.length) this.errorPlataforma=1;
            //     return this.errorPlataforma;
            // },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombrePlataformas='';
                this.descripcionPlataformas='';
                this.errors='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "plataforma":
                        {
                        switch(accion){
                            case 'registrar':{
                                this.modal = 1;
                                this.tituloModal = "Registrar Plataforma";
                                this.nombrePlataformas='';
                                this.descripcionPlataformas='';
                                this.tipoAccion = 1;
                                break;

                            }
                            case 'actualizar':{
                                this.modal = 1;
                                this.tipoAccion = 2;
                                this.tituloModal = "Actualizar Plataforma";
                                this.idPlataformas=data['idPlataformas'];
                                this.nombrePlataformas=data['nombrePlataformas'];
                                this.descripcionPlataformas=data['descripcionPlataformas'];
                                break;

                            }
                        }
                    }
                }
            }
        },
        
        mounted() {
            this.listarPlataforma(1, this.buscar, this.criterio);
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
</style>