<template>
     <main class="main">

           <div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-block" style="background-color: #e5e5e4">
        <div class="h1 text-muted text-right mb-2">
          <i class= "icon-game-controller" ></i>
        </div>
        <div class="h4 mb-0">87.500</div>
        <small class="text-muted text-uppercase font-weight-bold">Videojuegos en Inventario</small>
         
      </div>
      <div class="card-footer text-center" style="background-color:  #66CCFF">
            Ver <i class="fa fa-arrow-circle-right"></i>
        </div>
    </div>
  </div><!--/.col-->
  <div class="col-sm-6">
    <div class="card">
      <div class="card-block" style="background-color: #e5e5e4" >
        <div class="h1 text-muted text-right mb-2">
          <i class="icon-bag"></i>
        </div>
        <div class="h4 mb-0">{{arrayTipos.length}}</div>
        <small class="text-muted text-uppercase font-weight-bold">Últimas Transacciones</small>
        
      </div>
       <div  class="card-footer text-center" style="background-color:  #66CCFF">
            Ver  <i  class="fa fa-arrow-circle-right"></i>
        </div>
    </div>
  </div><!--/.col-->
  <div class="col-sm-6">
    <div class="card">
      <div class="card-block"  style="background-color: #e5e5e4">
        <div class="h1 text-muted text-right mb-2">
          <i class="icon-user-follow"></i>
        </div>
        <div class="h4 mb-0">1238</div>
        <small class="text-muted text-uppercase font-weight-bold">Clientes Registrados</small>
        
      </div>
      <div class="card-footer text-center" style="background-color:  #66CCFF">
            Ver <i class="fa fa-arrow-circle-right"></i>
        </div>
    </div>
  </div><!--/.col-->
  <div class="col-sm-6">
    <div class="card">
      <div class="card-block" style="background-color: #e5e5e4">
        <div class="h1 text-muted text-right mb-2">
          <i class="icon-people"></i>
        </div>
        <div class="h4 mb-0">28%</div>
        <small class="text-muted text-uppercase font-weight-bold">Socios registrados en redes Njoystick</small>
        
      </div>
      <div class="card-footer text-center" style="background-color:  #66CCFF">
            Ver <i class="fa fa-arrow-circle-right"></i>
        </div>
    </div>
  </div><!--/.col-->
  
 
</div><!--/.row-->
      
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
                errorTipo : 0,
                errorMsjTipo : [],
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
                if(this.validarTipo()){
                    return;
                }

                let me=this;
                axios.post('tipos/registrar',{
                    'nombreTipos': this.nombreTipos,
                    'descripcionTipos': this.descripcionTipos
                    }).then(function (response){
                        me.cerrarModal();
                        me.listarTipo(1,'', 'nombre');
                }).catch(function (error){
                    console.log(error);
                })
            },
            actualizarTipo(){
                if(this.validarTipo()){
                    return;
                }
                let me=this;
                axios.put('tipos/actualizar',{
                    'nombreTipos': this.nombreTipos,
                    'descripcionTipos': this.descripcionTipos,
                    'idTipos': this.idTipos
                    }).then(function (response){
                        me.cerrarModal();
                        me.listarTipo(1,'', 'nombre');
                }).catch(function (error){
                    console.log(error);
                })
            },
            validarTipo(){
                this.errorTipo=0;
                this.errorMsjTipo = [];

                if(!this.nombreTipos) this.errorMsjTipo.push("El nombre del Tipo no debe estar vacío");

                if(this.errorMsjTipo.length) this.errorTipo=1;
                return this.errorTipo;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombreTipos='';
                this.descripcionTipos='';
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