    @extends('principal')
    @section('contenido')

       <template v-if="menu==0">
        <example-component></example-component>
       </template>

       <template v-if="menu==1">
        <h1> Contenido del menú 1 </h1>
       </template>

       <template v-if="menu==2">
       <h1> Contenido del menú 2 </h1>
       </template>

       <template v-if="menu==3">
       <h1> Contenido del menú 3 </h1>
       </template>

       <template v-if="menu==4">
       <h1> Contenido del menú 4 </h1>
       </template>

       <template v-if="menu==5">
       <h1> Contenido del menú 5 </h1>
       </template>

       <template v-if="menu==6">
       <generos></generos>
       </template>

       <template v-if="menu==7">
       <h1> Contenido del menú 7 </h1>

       </template>

    @endsection