<template>
     <main class="main">

           <div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-block">
        <div class="h1 text-muted text-right mb-2">
          <i class= "icon-game-controller" ></i>
        </div>
        <div class="h4 mb-0">87.500</div>
        <small class="text-muted text-uppercase font-weight-bold">Videojuegos en Inventario</small>
        
      </div>
    </div>
  </div><!--/.col-->
  <div class="col-sm-6">
    <div class="card">
      <button type="card-block" @click="menu=7" >
        <div class="h1 text-muted text-right mb-2">
          <i class="icon-bag"></i>
        </div>
        <div class="h4 mb-0">{{arrayGeneros.length}}</div>
        <small class="text-muted text-uppercase font-weight-bold">Últimas Transacciones</small>
        
      </button>
    </div>
  </div><!--/.col-->
  <div class="col-sm-6">
    <div class="card">
      <div class="card-block">
        <div class="h1 text-muted text-right mb-2">
          <i class="icon-user-follow"></i>
        </div>
        <div class="h4 mb-0">1238</div>
        <small class="text-muted text-uppercase font-weight-bold">Clientes Registrados</small>
        
      </div>
    </div>
  </div><!--/.col-->
  <div class="col-sm-6">
    <div class="card">
      <div class="card-block">
        <div class="h1 text-muted text-right mb-2">
          <i class="icon-people"></i>
        </div>
        <div class="h4 mb-0">28%</div>
        <small class="text-muted text-uppercase font-weight-bold">Socios registrados en redes Njoystick</small>
        
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
                idGeneros:'0',
                nombreGeneros:'',
                descripcionGeneros:'',
                arrayGeneros:[],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorGenero : 0,
                errorMsjGenero : [],
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
                if(this.validarGenero()){
                    return;
                }

                let me=this;
                axios.post('generos/registrar',{
                    'nombreGeneros': this.nombreGeneros,
                    'descripcionGeneros': this.descripcionGeneros
                    }).then(function (response){
                        me.cerrarModal();
                        me.listarGenero(1,'', 'nombre');
                }).catch(function (error){
                    console.log(error);
                })
            },
            actualizarGenero(){
                if(this.validarGenero()){
                    return;
                }
                let me=this;
                axios.put('generos/actualizar',{
                    'nombreGeneros': this.nombreGeneros,
                    'descripcionGeneros': this.descripcionGeneros,
                    'idGeneros': this.idGeneros
                    }).then(function (response){
                        me.cerrarModal();
                        me.listarGenero(1,'', 'nombre');
                }).catch(function (error){
                    console.log(error);
                })
            },
            validarGenero(){
                this.errorGenero=0;
                this.errorMsjGenero = [];

                if(!this.nombreGeneros) this.errorMsjGenero.push("El nombre del género no debe estar vacío");

                if(this.errorMsjGenero.length) this.errorGenero=1;
                return this.errorGenero;
            },
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