<template>
     <main class="main">

            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Clientes
                        <button type="button" @click="abrirModal('cliente', 'registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombreClientes">Nombre</option>
                                      <option value="comunaClientes">Comuna</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarCliente(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarCliente(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>    
                        <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center">Código Njoystick</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Rut</th>
                                    <th class="text-center">Teléfono</th>
                                    <th class="text-center">Comuna</th>
                                    <th class="text-center">Correo Electrónico</th>
                                    <th class="text-center">Modificar</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr v-for="cliente in arrayClientes" :key="cliente.idClientes">
                                    <td v-text="'NJ'+cliente.idClientes"></td>
                                    <td v-text="cliente.nombreClientes"></td>
                                    <td v-text="cliente.rutClientes"></td>
                                    <td v-text="cliente.telefonoClientes"></td>
                                    <td v-text="cliente.comunaClientes"></td>
                                    <td v-text="cliente.correoClientes"></td>
                                    <td>
                                        <button type="button" @click="abrirModal('cliente', 'actualizar', cliente)" class="btn btn-warning btn-sm">
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
                                        <input type="text" v-model="nombreClientes" name="nombre" class="form-control" placeholder="Nombre de cliente">
                                        <span v-if="errors.nombreClientes" class="error">{{errors.nombreClientes[0]}}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Rut</label>
                                    <div class="col-md-9">
                                       <input type="text" v-rut v-model="rutClientes" name="rut" class="form-control" placeholder="Rut de Cliente">
                                        <span v-if="errors.rutClientes" class="error">{{errors.rutClientes[0]}}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Teléfono</label>
                                    <div class="col-md-9">
                                        <input type="number"  min="0" v-model="telefonoClientes" name="telefono" class="form-control" placeholder="Teléfono de cliente">
                                        <span v-if="errors.telefonoClientes" class="error">{{errors.telefonoClientes[0]}}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Comuna</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="comunaClientes" name="comuna" class="form-control" placeholder="Comuna de cliente">
                                        <span v-if="errors.comunaClientes" class="error">{{errors.comunaClientes[0]}}</span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Correo Electrónico</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="correoClientes" name="correo" class="form-control" placeholder="Correo electrónico de cliente">
                                        <span v-if="errors.correoClientes" class="error">{{errors.correoClientes[0]}}</span>
                                    </div>
                                </div>
                                <!-- <div v-show="errorCliente" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMsjCliente" :key="error" v-text="error">
                                        </div>
                                    </div>
                                </div> -->
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()" >Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarCliente()" >Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarCliente()">Actualizar</button>

                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>
<script src="validarRUT.js"></script>

<script>
    var vueRut = require('vue-rut');
    Vue.use(vueRut);
    export default {
        data(){
            return{
                idClientes:'0',
                nombreClientes:'',
                rutClientes:'',
                telefonoClientes:'',
                comunaClientes:'',
                correoClientes:'',
                arrayClientes:[],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errors: [],
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
            listarCliente(page, buscar, criterio){
                let me=this;
                var url= '/clientes?page='+page + '&buscar='+ buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayClientes = respuesta.clientes.data;
                    me.pagination=respuesta.pagination;
                })
                .catch(function (error){
                    console.log(error);
                })
            },
            cambiarPagina(page, buscar, criterio){
                let me=this;
                me.pagination.current_page=page;
                me.listarCliente(page, buscar, criterio);
            },
            registrarCliente(){
                // if(this.validarCliente()){
                //     return;
                // }
                this.errors= []
                let me=this;
                axios.post('clientes/registrar',{
                    'nombreClientes': this.nombreClientes,
                    'rutClientes': this.rutClientes,
                    'telefonoClientes': this.telefonoClientes,
                    'comunaClientes': this.comunaClientes,
                    'correoClientes': this.correoClientes,
                    }).then(function (response){
                        me.cerrarModal();
                        me.listarCliente(1,'', 'nombre');
                }).catch(error=>{
                    if(error.response.status == 422){
                        this.errors = error.response.data.errors
                    }
                    //  if(this.validaRut(rutClientes)){
                    //     this.errors = "RUT no valido"
                    // }
                })
            },
            actualizarCliente(){
                // if(this.validarCliente()){
                //     return;
                // }
                this.errors= []
                let me=this;
                axios.put('clientes/actualizar',{
                    'nombreClientes': this.nombreClientes,
                    'rutClientes': this.rutClientes,
                    'telefonoClientes': this.telefonoClientes,
                    'comunaClientes': this.comunaClientes,
                    'correoClientes': this.correoClientes,
                    'idClientes': this.idClientes
                    }).then(function (response){
                        me.cerrarModal();
                        me.listarCliente(1,'', 'nombre');
                }).catch(error=>{
                    if(error.response.status == 422){
                        this.errors = error.response.data.errors
                    }
                   
                    
                })
            },
            // validaRut: function(rutCompleto) {
            //     rutCompleto = rutCompleto.replace("‐","-");
            //     if (!/^[0-9]+[-|‐]{1}[0-9kK]{1}$/.test( rutCompleto ))
            //         return false;
            //     var tmp     = rutCompleto.split('-');
            //     var digv    = tmp[1];
            //     var rut     = tmp[0];
            //     if ( digv == 'K' ) digv = 'k' ;

            //     return (this.dv(rut) == digv );
            // },
            // dv : function(T){
            //     var M=0,S=1;
            //     for(;T;T=Math.floor(T/10))
            //         S=(S+T%10*(9-M++%6))%11;
            //     return S?S-1:'k';
            // },
            // validarCliente(){
            //     this.errorCliente=0;
            //     this.errorMsjCliente = [];

            //     if(!this.nombreClientes) this.errorMsjCliente.push("El nombre del cliente no debe estar vacío");

            //     if(this.errorMsjCliente.length) this.errorCliente=1;
            //     return this.errorCliente;
            // },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombreClientes='';
                this.rutClientes='';
                this.telefonoClientes='';
                this.comunaClientes='';
                this.correoClientes='';
                this.errorMsjCliente='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "cliente":
                        {
                        switch(accion){
                            case 'registrar':{
                                this.modal = 1;
                                this.tituloModal = "Registrar Cliente";
                                this.nombreClientes='';
                                this.rutClientes='';
                                this.telefonoClientes='';
                                this.comunaClientes='';
                                this.correoClientes='';
                                this.tipoAccion = 1;
                                break;

                            }
                            case 'actualizar':{
                                this.modal = 1;
                                this.tipoAccion = 2;
                                this.tituloModal = "Actualizar Cliente";
                                this.idClientes=data['idClientes'];
                                this.nombreClientes=data['nombreClientes'];
                                this.rutClientes=data['rutClientes'];
                                this.telefonoClientes=data['telefonoClientes'];
                                this.comunaClientes=data['comunaClientes'];
                                this.correoClientes=data['correoClientes'];
                                break;

                            }
                        }
                    }
                }
            }
        },
        
        mounted() {
            this.listarCliente(1, this.buscar, this.criterio);
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