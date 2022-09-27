@section('css')
<style>
    
    
    /* .mod {



    z-index: 1010;

    }
    .mod-overlay {

   
    z-index: 1000;

    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;

    }
    
    
     */
    
    
    
    
    
    
    
    
    
    
    
    
    .tablaservicios {
        width: 100%;
        min-width: 1100px;
        min-height: 140px;
    }
    .tablaservicios thead {
        background-color: #1572e8;
        color: white;
    }
    .tablaservicios th, td {
        border: 0.5px solid #1571e894;
        padding: 4px;
    }
    .tablaserviciostr:hover {
        background-color: rgba(0, 195, 255, 0.336);
    }
    .detalleservicios{
        border: 1px solid #1572e8;
        border-radius: 10px;
        background-color: #ffffff00;
        /* border-top: 4px; */
        padding: 5px;
    }

    .salidarepuestos{
 
        margin: 0.5rem;
     
    }
    .salidarepuestos td {
        border: 0.3px solid #8b8f9494;
        padding: 4px;
    }
    .salidarepuestos:hover {
        background-color: rgba(247, 185, 147, 0.336);
    }

    .salidarepuestos thead {
        background-color: #3f597e;
        font-family: Arial, Helvetica, sans-serif;
        color: white;
    }
    .asignar :hover {
        background-color: rgba(5, 214, 221, 0.486);
    }
    .imprimir :hover {
        background-color: rgba(18, 107, 240, 0.486);
    }
    .modificar :hover {
        background-color: rgba(10, 175, 4, 0.486);
    }
    .anular :hover {
        background-color: rgba(204, 184, 1, 0.486);
    }
    .eliminar :hover {
        background-color: rgba(224, 5, 5, 0.486);
    }

    .detallesservicios {
        border: 1px solid #aaaaaa;
        background-color: rgba(255, 255, 255, 0.589);
        -moz-border-radius: 7px;
        -webkit-border-radius: 7px;
        padding: 10px;
        margin-left: 15%;
        margin-right: 15%;
    }
    
    /*Estilos para el Boton Pendiente en la Tabla*/
    .pendienteestilos {
        text-decoration: none !important; 
        background-color: rgb(161, 0, 224);
        cursor: pointer;
        color: white;
        border-color: rgb(161, 0, 224);
        border-radius: 7px;
        padding-top: 2px;
        padding-bottom: 2px;
        padding-left: 5px;
        padding-right: 5px;
        box-shadow: none;
        border-width: 2px;
        border-style: solid;
        border-color: rgb(161, 0, 224);
        display: inline-block;
    }
    .pendienteestilos:hover {
        background-color: rgb(255, 255, 255);
        color: rgb(161, 0, 224);
        transition: all 0.4s ease-out;
        border-color: rgb(161, 0, 224);
        text-decoration: underline;
        -webkit-transform: scale(1.05);
        -moz-transform: scale(1.05);
        -ms-transform: scale(1.05);
        transform: scale(1.05);
        
    }


    /*Estilos para el Boton Proceso en la Tabla*/
    .procesoestilos {
        text-decoration: none !important; 
        background-color: rgb(100, 100, 100);
        cursor: pointer;
        color: white; 
        border-color: rgb(100, 100, 100);
        border-radius: 7px;
        padding-top: 2px;
        padding-bottom: 2px;
        padding-left: 5px;
        padding-right: 5px;
        box-shadow: none;
        border-width: 2px;
        border-style: solid;
        border-color: rgb(100, 100, 100);
        display: inline-block;
    }
    .procesoestilos:hover {
        background-color: rgb(255, 255, 255);
        color: rgb(100, 100, 100); 
        transition: all 0.5s ease-out;
        border-color: rgb(100, 100, 100);
        /* transform: translateY(-3px);  */

        text-decoration: underline;
        -webkit-transform: scale(1.05);
        -moz-transform: scale(1.05);
        -ms-transform: scale(1.05);
        transform: scale(1.05);
    }


    /*Estilos para el Boton Terminado en la Tabla*/
    .terminadoestilos {
        text-decoration: none !important; 
        background-color: rgb(224, 146, 0);
        cursor: pointer;
        color: white;
        border-color: rgb(224, 146, 0);
        border-radius: 7px;
        padding-top: 2px;
        padding-bottom: 2px;
        padding-left: 5px;
        padding-right: 5px;
        box-shadow: none;
        border-width: 2px;
        border-style: solid;
        border-color: rgb(224, 146, 0);
        display: inline-block;
    }
    .terminadoestilos:hover {
        background-color: rgb(255, 255, 255);
        color: rgb(224, 146, 0);
        transition: all 0.4s ease-out;
        border-color: rgb(224, 146, 0);
        text-decoration: underline;
        -webkit-transform: scale(1.05);
        -moz-transform: scale(1.05);
        -ms-transform: scale(1.05);
        transform: scale(1.05);
    }


    /*Estilos para el Boton Entregado en la Tabla*/
    .entregadoestilos {
        text-decoration: none !important; 
        background-color: rgb(22, 192, 0);
        color: white !important; 
        cursor: default;
        border:none;
        border-radius: 7px;
        padding-top: 2px;
        padding-bottom: 2px;
        padding-left: 5px;
        padding-right: 5px;
        box-shadow: none;
        border-width: 2px;
        border-style: solid;
        border-color: rgb(22, 192, 0);
        display: inline-block;
    }
    .entregadoestilos:hover {
        color: rgb(255, 255, 255) !important; 
    }





    /*Estilos para los nombres de los usuarios en la tabla de la ventana modal Asignar Técnico Responsable*/
    .nombresestilosmodal {
        background-color: rgb(255, 255, 255);
        color: rgb(0, 0, 0);
        cursor:pointer;
    }
    /*Estilos para el Botón Editar Servicio de la Tabla*/
    .botoneditar {
        background-color: #008a5c;
        
        cursor: pointer;
        color: white;
        border-color: #008a5c;
        border-radius: 7px;
    }
    .botoneditar:hover {
        background-color: rgb(255, 255, 255);
        color: #008a5c;
        transition: all 0.4s ease-out;
        border-color: #008a5c;
        transform: translateY(-2px);
    }


    /*Estilos para el Botón Editar Servicio Terminado de la Tabla*/
    .botoneditarterminado {
        background-color: #004585;
        
        cursor: pointer;
        color: white;
        border-color: #004585;
        border-radius: 7px;
    }
    .botoneditarterminado:hover {
        background-color: rgb(255, 255, 255);
        color: #004585;
        transition: all 0.4s ease-out;
        border-color: #000458508a5c;
        transform: translateY(-2px);
    }


    /* Estilos para la Tabla - Ventana Modal Asignar Técnico  Responsable*/
    .table-wrapper {
        width: 100%;/* Anchura de ejemplo */
        height: 350px; /* Altura de ejemplo */
        overflow: auto;
    }

    .table-wrapper table {
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-wrapper table thead {
        position: -webkit-sticky; /* Safari... */
        position: sticky;
        top: 0;
        left: 0;
        background-color: #007bff;
        color: white;
    }
        








    #preloader_3{
        position:relative;
    }
    #preloader_3:before{
        width:20px;
        height:20px;
        border-radius:20px;
        background:blue;
        content:'';
        position:absolute;
        background:#9b59b6;
        animation: preloader_3_before 1.5s infinite ease-in-out;
    }
 
    #preloader_3:after{
        width:20px;
        height:20px;
        border-radius:20px;
        background:blue;
        content:'';
        position:absolute;
        background:#2ecc71;
        left:22px;
        animation: preloader_3_after 1.5s infinite ease-in-out;
    }
 
    @keyframes preloader_3_before {
        0% {transform: translateX(0px) rotate(0deg)}
        50% {transform: translateX(50px) scale(1.2) rotate(260deg); background:#2ecc71;border-radius:0px;}
        100% {transform: translateX(0px) rotate(0deg)}
    }
    @keyframes preloader_3_after {
        0% {transform: translateX(0px)}
        50% {transform: translateX(-50px) scale(1.2) rotate(-260deg);background:#9b59b6;border-radius:0px;}
        100% {transform: translateX(0px)}
    }





    

</style>
@endsection
    



<div>
SOLICITUDES

    <div class="table-wrapper form-group">
        <table class="tablaservicios" style="min-width: 400px;">
            <thead>
                <tr>
                    <th class="text-center">N° Solicitud</th>
                    <th class="text-center">Tecnico Solicitante</th>
                    <th class="text-center">Servicio n°</th>
                    <th class="text-center">Accion</th>
                </tr>
            </thead>
            <tbody>
               
                    <tr>
                        <td>
                          1
                        </td>
                        <td class="text-center">
                           Fabio Garcia
                        </td>
                        <td class="text-center">
                          5202
                        </td>
                       
                        <td class="text-center">
                            <a href="javascript:void(0)" 
                                class="btn btn-dark mtmobile p-1 m-0" title="Edit">
                              Aprobar
                            </a>

                            <a href="javascript:void(0)"
                             
                                class="btn btn-danger p-1 m-0" title="Delete">
                              Rechazar
                            </a>
                        </td>
                       

                  
                    </tr>
         





                {{-- @foreach($listaproductos as $l)
                    <tr>
                        <td>
                            {{$l->prod_name}}
                        </td>
                        <td class="text-center">
                            {{$l->dest_name}}
                        </td>
                        <td class="text-center">
                            
                        </td>
                    </tr>
                @endforeach --}}

            </tbody>
        </table>
    </div>
    <br>
    <br>
    <br>

    SOLICITUD DE COMPRA DE REPUESTOS

    <div class="table-wrapper form-group">
        <table class="tablaservicios" style="min-width: 400px;">
            <thead>
                <tr>
                    <th class="text-center">N° Solicitud DE COMPRA</th>
                    <th class="text-center">Tecnico Solicitante</th>
                    <th class="text-center">ID SERVICIO</th>
                   
                    <th class="text-center">Accion</th>
                </tr>
            </thead>
            <tbody>
               
                    <tr>
                        <td>
                          1
                        </td>
                        <td class="text-center">
                           Fabio Garcia
                        </td>
                        <td class="text-center">
                          5202
                        </td>
                       
                        <td class="text-center">
                            <a href="javascript:void(0)"
                                class="btn btn-dark mtmobile p-1 m-0" title="Edit">
                              Ver Detalle
                            </a>

                            <a href="javascript:void(0)"
                              
                                class="btn btn-danger p-1 m-0" title="Delete">
                              Tomar Solicitud
                            </a>
                        </td>
                       

                  
                    </tr>
         





                {{-- @foreach($listaproductos as $l)
                    <tr>
                        <td>
                            {{$l->prod_name}}
                        </td>
                        <td class="text-center">
                            {{$l->dest_name}}
                        </td>
                        <td class="text-center">
                            
                        </td>
                    </tr>
                @endforeach --}}

            </tbody>
        </table>
    </div>




</div>
