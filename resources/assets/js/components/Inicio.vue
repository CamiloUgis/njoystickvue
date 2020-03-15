<template>
     <main class="main">

           <div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-block" style="background-color: #e5e5e4">
        <div class="h1 text-muted text-right mb-2">
          <i class= "icon-game-controller" ></i>
        </div>
        <div class="h4 mb-0">{{arrayProductos.length}}</div>
        <small class="text-muted text-uppercase font-weight-bold">Videojuegos en Inventario</small>
         
      </div>
      <div class="card-footer text-center" style="background-color:  #66CCFF">
           <a> Ver <i class="fa fa-arrow-circle-right" @click="verProductos()"></i></a>
        </div>
    </div>
  </div><!--/.col-->
  <div class="col-sm-6">
    <div class="card">
      <div class="card-block" style="background-color: #e5e5e4" >
        <div class="h1 text-muted text-right mb-2">
          <i class="icon-bag"></i>
        </div>
        <div class="h4 mb-0">{{arrayTransacciones.length}}</div>
        <small class="text-muted text-uppercase font-weight-bold">Últimas Transacciones</small>
        
      </div>
       <div  class="card-footer text-center" style="background-color:  #66CCFF">
          <a>  Ver  <i  class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
  </div><!--/.col-->
  <div class="col-sm-6">
    <div class="card">
      <div class="card-block"  style="background-color: #e5e5e4">
        <div class="h1 text-muted text-right mb-2">
          <i class="icon-user-follow"></i>
        </div>
        <div class="h4 mb-0">{{arrayClientes.length}}</div>
        <small class="text-muted text-uppercase font-weight-bold">Clientes Registrados</small>
        
      </div>
      <div class="card-footer text-center" style="background-color:  #66CCFF">
          <a>  Ver <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
  </div><!--/.col-->
  <div class="col-sm-6">
    <div class="card">
      <div class="card-block" style="background-color: #e5e5e4">
        <div class="h1 text-muted text-right mb-2">
          <i class="icon-people"></i>
        </div>
        <div class="h4 mb-0">{{calcularPorcentaje}}%</div>
        <small class="text-muted text-uppercase font-weight-bold">Socios registrados en redes Njoystick</small>
        
      </div>
      <div class="card-footer text-center" style="background-color:  #66CCFF">
          <a>  Ver <i class="fa fa-arrow-circle-right"></i></a>
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

                arrayClientes:[],
                arrayProductos:[],
                arrayTransacciones:[],
                arraySocios:[],
            }
        },
        computed:{
            calcularPorcentaje: function(){
                var resultado=0;
                resultado = (((this.arraySocios.length)/(this.arrayClientes.length))*100).toFixed(2);
                return resultado;
            }

        },
        methods:{
            verProductos(){
              let me=this;
              var url='/productos';
            
            },
             listarProducto(){
                let me=this;
                var url= '/productos/selectProducto';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayProductos = respuesta.productos;
                })
                .catch(function (error){
                    console.log(error.response);
                })
            },
            listarCliente(){
                let me=this;
                var url= '/clientes/selectCliente2';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayClientes = respuesta.clientes;
                })
                .catch(function (error){
                    console.log(error);
                })
            },
            listarTransaccion(){
                let me=this;
                var url= '/transacciones/selectTransaccion';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayTransacciones = respuesta.transacciones;
                })
                .catch(function (error){
                    console.log(error.response);
                })
            },
            listarSocio(){
                let me=this;
                var url= '/socios/selectSocio';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arraySocios = respuesta.socios;
                })
                .catch(function (error){
                    console.log(error);
                })
            },

            
           
        },
        
        mounted() {
            this.listarProducto();
            this.listarCliente();
            this.listarTransaccion();
            this.listarSocio();
        }
    }
</script>
