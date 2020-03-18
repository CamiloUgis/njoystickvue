<template>
     <main class="main">

            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Géneros
                        <button type="button" @click="abrirModal('genero', 'registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombreGeneros">Nombre</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarGenero(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarGenero(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Descripción</th>
                                    <th class="text-center">Modificar</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr v-for="genero in arrayGeneros" :key="genero.idGeneros">
                                    <td v-text="genero.nombreGeneros"></td>
                                    <td v-text="genero.descripcionGeneros"></td>

                                    <td>
                                        <button type="button" @click="abrirModal('genero', 'actualizar', genero)" class="btn btn-warning btn-sm">
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
                                        <input type="text" v-model="nombreGeneros" name="nombre" class="form-control" placeholder="Nombre de género">
                                        <span v-if="errors.nombreGeneros" class="error">{{errors.nombreGeneros[0]}}</span>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="descripcionGeneros" name="descripcion" class="form-control" placeholder="Descripción de género">
                                        <span v-if="errors.descripcionGeneros" class="error">{{errors.descripcionGeneros[0]}}</span>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()" >Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarGenero()" >Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarGenero()">Actualizar</button>

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
                idGeneros:'0',
                nombreGeneros:'',
                descripcionGeneros:'',
                arrayGeneros:[],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errors: [],
                // errorGenero : 0,
                // errorMsjGenero : [],
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
            listarGenero(page, buscar, criterio){
                let me=this;
                var url= '/generos?page='+page + '&buscar='+ buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayGeneros = respuesta.generos.data;
                    me.pagination=respuesta.pagination;
                })
                .catch(function (error){
                    console.log(error);
                })
            },
            cambiarPagina(page, buscar, criterio){
                let me=this;
                me.pagination.current_page=page;
                me.listarGenero(page, buscar, criterio);
            },
            registrarGenero(){
                // if(this.validarGenero()){
                //     return;
                // }
                this.errors= []
                let me=this;
                axios.post('generos/registrar',{
                    'nombreGeneros': this.nombreGeneros,
                    'descripcionGeneros': this.descripcionGeneros
                    }).then(function (response){
                        me.cerrarModal();
                        me.listarGenero(1,'', 'nombre');
                }).catch(error=>{
                    if(error.response.status == 422){
                        this.errors = error.response.data.errors
                    }
                })
            },
            actualizarGenero(){
                // if(this.validarGenero()){
                //     return;
                // }
                this.errors= []
                let me=this;
                axios.put('generos/actualizar',{
                    'nombreGeneros': this.nombreGeneros,
                    'descripcionGeneros': this.descripcionGeneros,
                    'idGeneros': this.idGeneros
                    }).then(function (response){
                        me.cerrarModal();
                        me.listarGenero(1,'', 'nombre');
                }).catch(error=>{
                    if(error.response.status == 422){
                        this.errors = error.response.data.errors
                    }
                })
            },
            // validarGenero(){
            //     this.errorGenero=0;
            //     this.errorMsjGenero = [];

            //     if(!this.nombreGeneros) this.errorMsjGenero.push("El nombre del género no debe estar vacío");

            //     if(this.errorMsjGenero.length) this.errorGenero=1;
            //     return this.errorGenero;
            // },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombreGeneros='';
                this.descripcionGeneros='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "genero":
                        {
                        switch(accion){
                            case 'registrar':{
                                this.modal = 1;
                                this.tituloModal = "Registrar Género";
                                this.nombreGeneros='';
                                this.descripcionGeneros='';
                                this.tipoAccion = 1;
                                break;

                            }
                            case 'actualizar':{
                                this.modal = 1;
                                this.tipoAccion = 2;
                                this.tituloModal = "Actualizar Género";
                                this.idGeneros=data['idGeneros'];
                                this.nombreGeneros=data['nombreGeneros'];
                                this.descripcionGeneros=data['descripcionGeneros'];
                                break;

                            }
                        }
                    }
                }
            }
        },
        
        mounted() {
            this.listarGenero(1, this.buscar, this.criterio);
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