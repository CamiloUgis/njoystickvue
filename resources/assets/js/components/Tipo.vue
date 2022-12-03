<template>
     <main class="main">

            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Tipos
                        <button type="button" @click="abrirModal('tipo', 'registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombreTipos">Nombre</option>
                                      <option value="descripcionTipos">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarTipo(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarTipo(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Descripción</th>
                                    <th class="text-center">Modificar</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr v-for="tipo in arrayTipos" :key="tipo.idTipos">
                                    <td v-text="tipo.nombreTipos"></td>
                                    <td v-text="tipo.descripcionTipos"></td>

                                    <td>
                                        <button type="button" @click="abrirModal('tipo', 'actualizar', tipo)" class="btn btn-warning btn-sm">
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
                                </li>
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
                                        <input type="text" v-model="nombreTipos" name="nombre" class="form-control" placeholder="Nombre de tipo">
                                        <span v-if="errors.nombreTipos" class="error">{{errors.nombreTipos[0]}}</span>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="descripcionTipos" name="descripcion" class="form-control" placeholder="Descripción de tipo">
                                        <span v-if="errors.descripcionTipos" class="error">{{errors.descripcionTipos[0]}}</span>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()" >Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarTipo()" >Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarTipo()">Actualizar</button>

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
                idTipos:'0',
                nombreTipos:'',
                descripcionTipos:'',
                arrayTipos:[],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errors: [],
                // errorTipo : 0,
                // errorMsjTipo : [],
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
            listarTipo(page, buscar, criterio){
                let me=this;
                var url= '/tipos?page='+page + '&buscar='+ buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayTipos = respuesta.tipos.data;
                    me.pagination=respuesta.pagination;
                })
                .catch(function (error){
                    console.log(error);
                })
            },
            cambiarPagina(page, buscar, criterio){
                let me=this;
                me.pagination.current_page=page;
                me.listarTipo(page, buscar, criterio);
            },
            registrarTipo(){
                // if(this.validarTipo()){
                //     return;
                // }
                this.errors= []
                let me=this;
                axios.post('tipos/registrar',{
                    'nombreTipos': this.nombreTipos,
                    'descripcionTipos': this.descripcionTipos
                    }).then(function (response){
                        me.cerrarModal();
                        me.listarTipo(1,'', 'nombre');
                }).catch(error=>{
                    if(error.response.status == 422){
                        this.errors = error.response.data.errors
                    }
                })
            },
            actualizarTipo(){
                // if(this.validarTipo()){
                //     return;
                // }
                this.errors= []
                let me=this;
                axios.put('tipos/actualizar',{
                    'nombreTipos': this.nombreTipos,
                    'descripcionTipos': this.descripcionTipos,
                    'idTipos': this.idTipos
                    }).then(function (response){
                        me.cerrarModal();
                        me.listarTipo(1,'', 'nombre');
                }).catch(error=>{
                    if(error.response.status == 422){
                        this.errors = error.response.data.errors
                    }
                })
            },
            // validarTipo(){
            //     this.errorTipo=0;
            //     this.errorMsjTipo = [];

            //     if(!this.nombreTipos) this.errorMsjTipo.push("El nombre del tipo no debe estar vacío");

            //     if(this.errorMsjTipo.length) this.errorTipo=1;
            //     return this.errorTipo;
            // },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombreTipos='';
                this.descripcionTipos='';
                this.errors='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "tipo":
                        {
                        switch(accion){
                            case 'registrar':{
                                this.modal = 1;
                                this.tituloModal = "Registrar Tipo";
                                this.nombreTipos='';
                                this.descripcionTipos='';
                                this.tipoAccion = 1;
                                break;

                            }
                            case 'actualizar':{
                                this.modal = 1;
                                this.tipoAccion = 2;
                                this.tituloModal = "Actualizar Tipo";
                                this.idTipos=data['idTipos'];
                                this.nombreTipos=data['nombreTipos'];
                                this.descripcionTipos=data['descripcionTipos'];
                                break;

                            }
                        }
                    }
                }
            }
        },
        
        mounted() {
            this.listarTipo(1, this.buscar, this.criterio);
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