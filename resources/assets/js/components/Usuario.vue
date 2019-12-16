<template>
     <main class="main">

            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Usuario
                        <button type="button" @click="abrirModal('usuarios', 'registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center">Usuario</th>
                                    <th class="text-center">Rol</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr v-for="usuario in arrayUsuarios" :key="usuario.idUsuarios">
                                    <td v-text="usuario.nickUsuarios"></td>
                                    <td v-text="usuario.nombreRoles"></td>
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
                                        <input type="text" v-model="nickUsuarios" name="nombre" class="form-control" placeholder="Nombre de usuario">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="number-input">Contraseña</label>
                                    <div class="col-md-9">
                                        <input type="password" v-model="password" name="pass" class="form-control" placeholder="Contraseña del usuario">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="number-input">Rol</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idRoles">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="roles in arrayRoles" :key="roles.idRoles"
                                            :value="roles.idRoles" v-text="roles.nombreRoles"></option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()" >Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarUsuarios()" >Guardar</button>
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
                idUsuarios:0,
                idRoles:0,
                nickUsuarios:'',
                password:'',
                arrayUsuarios:[],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
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
                arrayRoles:[]

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
            listarUsuarios(page, buscar, criterio){
                let me=this;
                var url= '/usuarios?page='+page + '&buscar='+ buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayUsuarios = respuesta.usuarios.data;
                    me.pagination=respuesta.pagination;

                })
                .catch(function (error){
                    console.log(error.response);
                })
            },
            selectRoles(){
                let me=this;
                var url= '/roles/selectRoles';
                axios.get(url).then(function (response){
                    //console.log(response);
                    var respuesta = response.data;
                    me.arrayRoles = respuesta.roles;
                })
                .catch(function (error){
                    console.log(error.response);
                })
            },
            cambiarPagina(page, buscar, criterio){
                let me=this;
                me.pagination.current_page=page;
                me.listarUsuarios(page, buscar, criterio);
            },
            registrarUsuarios(){
                let me=this;
                axios.post('usuarios/registrar',{
                    'nickUsuarios': this.nickUsuarios,
                    'password': this.password,    
                    'idRoles': this.idRoles,
                    }).then(function (response){
                        me.cerrarModal();
                        me.listarUsuarios(1,'', 'nombre');
                }).catch(function (error){
                    console.log(error.response);
                })

            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nickUsuarios='';
                this.idRoles=0,
                this.password='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "usuarios":
                        {
                        switch(accion){
                            case 'registrar':{
                                this.modal = 1;
                                this.tituloModal = "Registrar usuarios";
                                this.tituloModal='';
                                this.nickUsuarios='';
                                this.idRoles=0,
                                this.tipoAccion = 1;
                                break;

                            }
                        }
                    }
                }
                this.selectRoles();
            }
        },
        
        mounted() {
            this.listarUsuarios(1, this.buscar, this.criterio);
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