    @extends('principal')
    @section('contenido')

       <template v-if="menu==0">
       <inicio></inicio>

       </template>

       <template v-if="menu==1">
       <clientes></clientes>
       </template>

       <template v-if="menu==2">
       <socios></socios>
       </template>

       <template v-if="menu==3">
       <transacciones></transacciones>
       </template>

       <template v-if="menu==4">
       <h1> Contenido del menú 4 </h1>
       </template>

       <template v-if="menu==5">
       <productos></productos>
       </template>

       <template v-if="menu==6">
       <generos></generos>
       </template>

       <template v-if="menu==7">
       <plataformas></plataformas>
       </template>
      <!-- <template v-if="menu==8">
       <usuarios></usuarios>
       </template> -->
       <template v-if="menu==9">
       <ventas></ventas>
       </template>
       <template v-if="menu==10">
       <arriendos></arriendos>
       </template>
       <template v-if="menu==11">
       <canjes></canjes>
       </template>
       <template v-if="menu==12">
       <reservas></reservas>
       </template>

    @endsection