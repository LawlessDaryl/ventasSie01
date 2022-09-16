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
    .salidarepuestos th, td {
        border: 0.5px solid #5e656f94;
        padding: 4px;
    }
    .salidarepuestos:hover {
        background-color: rgba(55, 79, 86, 0.336);
    }

    .salidarepuestos thead {
        background-color: #4d5765;
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
    
    
<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">

            <div class="form-group">
                <div class="row">

                    <div class="col-12 col-sm-12 col-md-4 text-center">

                    </div>

                    <div class="col-12 col-sm-12 col-md-4 text-center">
                        <h2><b>ORDENES DE SERVICIO</b></h2>
                        Ordenados por Fecha de Recepción
                    </div>

                    <div class="col-12 col-sm-12 col-md-4">
                        @if(@Auth::user()->hasPermissionTo('Recepcionar_Servicio'))
                            <ul class="tabs tab-pills text-right">
                                <a href="javascript:void(0)" wire:click="irservicio()" class="btn btn-outline-primary">Nuevo Servicio</a>
                                <a href="{{ url('inicio') }}" class="btn btn-outline-primary">Ir a Lista Servicios</a>

                                <div class="custom-control custom-switch" style="padding-top: 5px;">
                                    <input type="checkbox" class="custom-control-input" id="customSwitches"
                                    wire:change="mostrarocultarmasfiltros()" {{ $masfiltros ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="customSwitches">+Filtros</label>
                                </div>

                            </ul>
                        @endif

                          
                    </div>

                </div>
            </div> 

            <div class="form-group">
                <div class="row">

                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b wire:click="limpiarsearch()" style="cursor: pointer;">Buscar...</b>
                        <div class="form-group">
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text input-gp">
                                        <i class="fas fa-search"></i>
                                    </span>
                                </div>
                                <input type="text" wire:model="search" placeholder="Busqueda General..." class="form-control">
                            </div>
                        </div>
                    </div>
                    @if(Auth::user()->hasPermissionTo('Filtrar_sucursal_Reporte_Servicio'))
                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Seleccionar Sucursal</b>
                        <div class="form-group">
                            <select wire:model="sucursal_id" class="form-control">
                                @foreach($listasucursales as $sucursal)
                                <option value="{{$sucursal->id}}">{{$sucursal->name}}</option>
                                @endforeach
                                <option value="Todos">Todas las Sucursales</option>
                            </select>
                        </div>
                    </div>
                    @endif
                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Categoría Trabajo</b>
                        <div class="form-group">
                            <select wire:model.lazy="catprodservid" class="form-control">
                                <option value="Todos" selected>Todos</option>
                                @foreach ($categorias as $cat)
                                    <option value="{{ $cat->id }}">{{ ucwords(strtolower($cat->nombre)) }}</option>
                                @endforeach
                            </select>
                            @error('catprodservid')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Tipo de Servicio</b>
                        <div class="form-group">
                            <select wire:model="type" class="form-control">
                                <option value="PENDIENTE">Pendientes</option>
                                <option value="PROCESO">Proceso</option>
                                <option value="TERMINADO">Terminados</option>
                                <option value="ENTREGADO">Entregados</option>
                                {{-- <option value="ABANDONADO">Abandonados</option> --}}
                                {{-- <option value="ANULADO">Anulados</option> --}}
                                <option value="Todos">Todos</option>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
                
            











            @if($this->masfiltros)

            <div class="form-group">
                <div class="row">
                    @if(Auth::user()->hasPermissionTo('Asignar_Tecnico_Servicio'))
                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Seleccione Usuario</b>
                        <div class="form-group">
                            <select wire:model="usuario" class="form-control">
                                @foreach($this->lista_de_usuarios as $i)
                                <option value="{{$i->idusuario}}">{{$i->nombreusuario}}</option>
                                @endforeach
                                <option value="Todos">Todos</option>
                            </select>
                        </div>
                    </div>
                    @endif
                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Tipo de Fecha</b>
                        <div class="form-group">
                            <select wire:model="tipofecha" class="form-control">
                                <option value="Todos" selected>Todas las Fechas</option>
                                <option value="Dia">Hoy</option>
                                <option value="Rango">Rango de Fechas</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Fecha Inicio</b>
                        <div class="form-group">
                            <input @if ($tipofecha != 'Rango') disabled @endif type="date" wire:model="dateFrom" class="form-control flatpickr" >
                        </div>
                    </div>

                    <div class="col-12 col-sm-6 col-md-3 text-center">
                        <b>Fecha Fin</b>
                        <div class="form-group">
                            <input @if ($tipofecha != 'Rango') disabled @endif type="date" wire:model="dateTo" class="form-control flatpickr" >
                        </div>
                    </div>

                </div>
            </div>

            @endif


            <center><div id="preloader_3" wire:loading></div></center>



            






            <br>

            <div class="widget-content">

                {{-- <h2 class="text-center text-warning" wire:loading>POR FAVOR ESPERE, OBTENIENDO INFORMACION</h2> --}}

            

                <div class="table-responsive">
                    <table class="tablaservicios">
                        <thead>
                            <tr>
                                <th class="text-center" style="min-width: 20px;">#</th>
                                <th class="text-center">CODIGO</th>
                                <th class="text-center">FECHA RECEPCION</th>
                                <th class="text-center">FECHA ESTIMADA ENTREGA</th>
                                <th class="text-center">RESPONSABLE TECNICO</th>
                                <th class="text-center">SERVICIOS</th>
                                <th class="text-center">PRECIO</th>
                                <th class="text-center">TECNICO RECEPTOR</th>
                                <th class="text-center">ESTADO</th>
                                <th class="text-center">EDITAR</th>
                                <th class="text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orden_de_servicio as $os)
                                <tr class="tablaserviciostr">
                                    <td class="text-center" style="min-width: 20px;">
                                        {{ ($orden_de_servicio->currentpage()-1) * $orden_de_servicio->perpage() + $loop->index + 1 }}
                                    </td>
                                    <td class="text-center">
                                        <span class="stamp stamp" style="background-color: #1572e8">
                                            {{$os->codigo}}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($os->fechacreacion)->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="text-center">

                                        @if($os->servicios->count() == 1)
                                            @foreach ($os->servicios as $d)
                                            {{ \Carbon\Carbon::parse($d->fecha_estimada_entrega)->format('d/m/Y H:i') }}
                                            @endforeach
                                        @else
                                        @foreach ($os->servicios as $d)
                                            <div style="padding-top: 15px;">
                                                {{ \Carbon\Carbon::parse($d->fecha_estimada_entrega)->format('d/m/Y H:i') }}
                                            </div>
                                        @endforeach
                                        @endif

                                    </td>
                                    <td class="text-center">
                                        @if($os->servicios->count() == 1)
                                            @foreach ($os->servicios as $rt)
                                            {{ucwords(strtolower($rt->responsabletecnico))}}
                                            @endforeach
                                        @else
                                            @foreach ($os->servicios as $rt)
                                                <div style="padding-top: 15px;">
                                                    {{ucwords(strtolower($rt->responsabletecnico))}}
                                                </div>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        Cliente: <b>{{ucwords(strtolower($os->nombrecliente))}}</b> | Sucursal: <b>{{$os->nombresucursal}}</b>

                                        @foreach ($os->servicios as $d)

                                            @if($os->servicios->count() == 1)
                                            <div>
                                                <a href="javascript:void(0)" wire:click="modalserviciodetalles('{{$d->estado}}' , {{ $d->idservicio }}, {{ $os->codigo }})">
                                                    {{ucwords(strtolower($d->nombrecategoria))}} {{ucwords(strtolower($d->marca))}} {{strtolower($d->detalle)}}
                                                    <br>
                                                    <b>Falla Según Cliente:</b> {{ucwords(strtolower($d->falla_segun_cliente))}}
                                                </a>
                                            </div>
                                            @else
                                            <div style="background-color: rgba(255, 230, 210, 0.829);">
                                                <a href="javascript:void(0)" wire:click="modalserviciodetalles('{{$d->estado}}' , {{ $d->idservicio }}, {{ $os->codigo }})">
                                                    {{ucwords(strtolower($d->nombrecategoria))}} {{ucwords(strtolower($d->marca))}} {{strtolower($d->detalle)}}
                                                    <br>
                                                    <b>Falla Según Cliente:</b> {{ucwords(strtolower($d->falla_segun_cliente))}}
                                                </a>
                                            </div>
                                            @endif

                                        @endforeach
                                    </td>
                                    <td class="text-right">
                                        
                                        @if($os->servicios->count() == 1)
                                            @foreach ($os->servicios as $d)
                                                {{$d->importe}}
                                            @endforeach
                                        @else
                                            @foreach ($os->servicios as $d)
                                                <div style="padding-top: 15px;">
                                                    {{$d->importe}}
                                                </div>
                                            @endforeach
                                        @endif

                                    </td>
                                    <td class="text-center">
                                        
                                        @if($os->servicios->count() == 1)
                                            @foreach ($os->servicios as $dss)
                                                {{ucwords(strtolower($dss->tecnicoreceptor))}}
                                            @endforeach
                                        @else
                                            @foreach ($os->servicios as $dss)
                                                <div style="padding-top: 15px;">
                                                    {{ucwords(strtolower($dss->tecnicoreceptor))}}
                                                </div>
                                            @endforeach
                                        @endif

                                    </td>
                                    <td class="text-center">

                                        @if($os->servicios->count() == 1)
                                            @foreach ($os->servicios as $d)
                                                @if($d->estado=="PENDIENTE")
                                                    @if (Auth::user()->hasPermissionTo('Asignar_Tecnico_Servicio'))
                                                        <a href="javascript:void(0)" class="pendienteestilos" wire:click="modalasignartecnico({{$d->idservicio}}, {{$os->codigo}})" title="Asignar Técnico Responsable">
                                                            {{$d->estado}}
                                                        </a>
                                                    @else
                                                        <button type="button" class="pendienteestilos" onclick="ConfirmarTecnicoResponsable('{{ $os->codigo }}','{{ ucwords(strtolower($os->nombrecliente)) }}', {{$d->idservicio}})" title="Ser Técnico Responsable de este Servicio">
                                                            {{$d->estado}}
                                                        </button>
                                                    @endif
                                                @else
                                                    @if($d->estado == "PROCESO")
                                                        <a href="javascript:void(0)" class="procesoestilos" wire:click="modaleditarservicio2('{{$d->estado}}', {{$d->idservicio}}, {{$os->codigo}})" title="Registrar Servicio Terminado o Actualizar Servicio">
                                                            {{$d->estado}}
                                                        </a>
                                                    @else
                                                        @if($d->estado=="TERMINADO")
                                                            <a href="javascript:void(0)" class="terminadoestilos" wire:click="modalentregarservicio('{{$d->estado}}', {{$d->idservicio}}, {{$os->codigo}})" title="Registrar Servicio como Entregado">
                                                                {{$d->estado}}
                                                            </a>
                                                        @else
                                                            @if($d->estado=="ENTREGADO")
                                                                <a href="javascript:void(0)" class="entregadoestilos">
                                                                    {{$d->estado}}
                                                                </a>
                                                            @else
                                                                @if($d->estado=="ABANDONADO")
                                                                    <button class="stamp stamp" style="background-color: rgb(186, 238, 0)">
                                                                        {{$d->estado}}
                                                                    </button>
                                                                @else
                                                                    @if($d->estado=="ANULADO")
                                                                        <button class="stamp stamp" style="background-color: rgb(0, 0, 0)">
                                                                            {{$d->estado}}
                                                                        </button>
                                                                    @else
                                                                        {{$d->estado}}
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach ($os->servicios as $d)
                                                @if($d->estado=="PENDIENTE")
                                                    @if (Auth::user()->hasPermissionTo('Asignar_Tecnico_Servicio'))
                                                        <a href="javascript:void(0)" style="margin-top: 17px;" class="pendienteestilos" wire:click="modalasignartecnico({{$d->idservicio}}, {{$os->codigo}})" title="Asignar Técnico Responsable">
                                                            {{$d->estado}}
                                                        </a>
                                                    @else
                                                        <a href="javascript:void(0)" style="margin-top: 17px;" class="pendienteestilos" onclick="ConfirmarTecnicoResponsable('{{ $os->codigo }}','{{ ucwords(strtolower($os->nombrecliente)) }}', {{$d->idservicio}})" title="Ser Técnico Responsable de este Servicio">
                                                            {{$d->estado}}
                                                        </a>
                                                    @endif
                                                @else
                                                    @if($d->estado=="PROCESO")
                                                        <a href="javascript:void(0)" style="margin-top: 17px;" class="procesoestilos" wire:click="modaleditarservicio2('{{$d->estado}}', {{$d->idservicio}}, {{$os->codigo}})" title="Registrar Servicio Terminado o Actualizar Servicio">
                                                            {{$d->estado}}
                                                        </a>
                                                    @else
                                                        @if($d->estado=="TERMINADO")
                                                            <a href="javascript:void(0)" style="margin-top: 17px;" class="terminadoestilos" wire:click="modalentregarservicio('{{$d->estado}}', {{$d->idservicio}}, {{$os->codigo}})" title="Registrar Servicio como Entregado">
                                                                {{$d->estado}}
                                                            </a>
                                                        @else
                                                            @if($d->estado=="ENTREGADO")
                                                                <a href="javascript:void(0)" style="margin-top: 17px;" class="entregadoestilos">
                                                                    {{$d->estado}}
                                                                </a>
                                                            @else
                                                                @if($d->estado=="ABANDONADO")
                                                                    <button class="stamp stamp" style="background-color: rgb(186, 238, 0)">
                                                                        {{$d->estado}}
                                                                    </button>
                                                                @else
                                                                    @if($d->estado=="ANULADO")
                                                                        <button class="stamp stamp" style="background-color: rgb(0, 0, 0)">
                                                                            {{$d->estado}}
                                                                        </button>
                                                                    @else
                                                                        {{$d->estado}}
                                                                    @endif
                                                                @endif
                                                            @endif
                                                        @endif
                                                    @endif
                                                @endif
                                                <br>
                                            @endforeach
                                        @endif



                                        
                                    </td>
                                    <td class="text-center">


                                        @if($os->servicios->count() == 1)
                                            @foreach ($os->servicios as $d)
                                                @if($d->estado != "ENTREGADO")
                                                    <button class="botoneditar" wire:click="modaleditarservicio1('{{$d->estado}}',{{$d->idservicio}},{{$os->codigo}})" title="Editar Servicio">
                                                        EDITAR
                                                    </button>
                                                @else
                                                    @if(@Auth::user()->hasPermissionTo('Modificar_Detalle_Serv_Entregado'))
                                                    <button class="botoneditarterminado" wire:click="modaleditarservicioterminado('{{$d->estado}}',{{$d->idservicio}},{{$os->codigo}})" title="Editar Precio Servicio">
                                                        EDITAR
                                                    </button>
                                                    @else
                                                        {{-- Espacio para que no se descuadre los botones --}}
                                                        <div style="padding-top: 15px;">
                                                            <button style="background-color: #00458500; border-color: #00458500;">
                                                                
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif
                                            @endforeach
                                        @else
                                            @foreach ($os->servicios as $d)
                                                @if($d->estado != "ENTREGADO")
                                                    <button class="botoneditar" style="margin-top: 15px;" wire:click="modaleditarservicio1('{{$d->estado}}',{{$d->idservicio}},{{$os->codigo}})" title="Editar Servicio">
                                                        EDITAR
                                                    </button>
                                                    <br>
                                                @else
                                                     @if(@Auth::user()->hasPermissionTo('Modificar_Detalle_Serv_Entregado'))
                                                        <div style="padding-top: 15px;">
                                                            <button class="botoneditarterminado" wire:click="modaleditarservicioterminado('{{$d->estado}}',{{$d->idservicio}},{{$os->codigo}})" title="Editar Precio Servicio">
                                                                EDITAR
                                                            </button>
                                                        </div>
                                                    @else
                                                        {{-- Espacio para que no se descuadre los botones --}}
                                                        <div style="padding-top: 15px;">
                                                            <button style="background-color: #00458500; border-color: #00458500;">
                                                                
                                                            </button>
                                                        </div>
                                                    @endif
                                                @endif

                                            @endforeach
                                        @endif





                                        
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                            <div class="btn-group" role="group">
                                                <button id="btnGroupDrop1" type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Opciones
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                                                    {{-- <div class="asignar">
                                                        <a class="dropdown-item" href="#">Imprimir Servicio</a>
                                                    </div> --}}
                                                    <div class="imprimir">
                                                        <a class="dropdown-item" href="{{ url('reporte/pdf' . '/' . $os->codigo) }}">Imprimir Orden de Servicio</a>
                                                    </div>
                                                    @if(@Auth::user()->hasPermissionTo('Modificar_Detalle_Serv'))
                                                    <div class="modificar">
                                                        <a class="dropdown-item" href="javascript:void(0)" wire:click="modificarordenservicio({{$os->idcliente}},{{$os->codigo}},'{{$os->tiposervicio}}')">Modificar Orden de Servicio</a>
                                                    </div>
                                                    @endif
                                                    @if(@Auth::user()->hasPermissionTo('Anular_Servicio'))
                                                    <div class="anular">
                                                        <a class="dropdown-item" href="#" onclick="ConfirmarAnular('{{ $os->codigo }}','{{ $os->nombrecliente }}')">Anular Orden de Servicio</a>
                                                    </div>
                                                    @endif
                                                    @if(@Auth::user()->hasPermissionTo('Eliminar_Servicio'))
                                                    <div class="eliminar">
                                                        <a class="dropdown-item" href="#" onclick="ConfirmarEliminar('{{ $os->codigo }}','{{ $os->nombrecliente }}')">Eliminar Orden de Servicio</a>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $orden_de_servicio->links() }}
            </div>
        </div>
    </div>
    @include('livewire.order_service.modalserviciodetalles')
    @include('livewire.order_service.modalasignartecnicoresponsable')
    @include('livewire.order_service.modaleditarservicio')
    @include('livewire.order_service.modaleditarservicioterminado')
    @include('livewire.order_service.modalentregarservicio')
    @include('livewire.order_service.salidarepuestos')
</div>
    
@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('show-sd', Msg => {
            $('#serviciodetalles').modal('show')
        });

        window.livewire.on('show-asignartecnicoresponsable', Msg => {
            $('#asignartecnicoresponsable').modal('show')
        });
        window.livewire.on('show-registrarterminado', Msg => {
            $('#registrarterminado').modal('show')
        });
        window.livewire.on('show-editarserviciomostrar', Msg => {
            $('#editarservicio').modal('show')
        });
        window.livewire.on('show-editarservicioterminado', Msg => {
            $('#editarservicioterminado').modal('show')
        });
        window.livewire.on('show-entregarservicio', Msg => {
            $('#entregarservicio').modal('show')
        });
        window.livewire.on('salidaregistrada', Msg => {
            $('#salidarepuestos').modal('hide')
        });

        //Cerrar Ventana Modal y Mostrar Toast Técnico Responsable Asignado Exitosamente
        window.livewire.on('show-asignartecnicoresponsablecerrar', msg => {
            $('#asignartecnicoresponsable').modal('hide')
            const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            padding: '2em'
            });
            toast({
                type: 'success',
                title: 'Técnico Responsable Asignado Exitosamente',
                padding: '2em',
            })
        });


        

        //Cerrar Ventana Modal y Mostrar Toast Servicio Actualizado Correctamente
        window.livewire.on('show-editarservicioocultar', msg => {
                        $('#editarservicio').modal('hide')
            const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2500,
            padding: '2em'
            });
            toast({
                type: 'success',
                title: '¡Servicio Actualizado Correctamente!',
                padding: '2em',
            })
        });
        //Cerrar Ventana Modal y Mostrar Toast Precio del Servicio Terminado Actualizado Correctamente
        window.livewire.on('show-editarservicioterminadoocultar', msg => {
                        $('#editarservicioterminado').modal('hide')
            const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            padding: '2em'
            });
            toast({
                type: 'success',
                title: '¡Servicio Terminado Actualizado Correctamente!',
                padding: '2em',
            })
        });

        //Cerrar Ventana Modal y Mostrar Toast Servicio Terminado Exitosamente
        window.livewire.on('show-terminarservicio', msg => {
                        $('#editarservicio').modal('hide')
            const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2500,
            padding: '2em'
            });
            toast({
                type: 'success',
                title: '¡Servicio Terminado Exitosamente!',
                padding: '2em',
            })
        });

        //Cerrar Ventana Modal y Mostrar Toast Servicio Entregado Exitosamente
        window.livewire.on('servicioentregado', msg => {
                        $('#entregarservicio').modal('hide')
            const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2500,
            padding: '2em'
            });
            toast({
                type: 'success',
                title: '¡Servicio Marcado como Entregado Exitosamente!',
                padding: '2em',
            })
        });



        //Mostrar Mensaje Hacerse Técnico Responsable de un Servicio
        window.livewire.on('responsable-tecnico', event => {
            swal(
                '¡Asignado Correctamente!',
                'Fuiste Asignado a la Orden de Servicio "' + @this.id_orden_de_servicio + '" exitósamente',
                'success'
                )
        });


        //Mostrar Mensaje Anulado con Éxito
        window.livewire.on('orden-anulado', event => {
            swal(
                '¡Anulado!',
                'La Orden de Servicio: "'+ @this.id_orden_de_servicio +'" fue anulado con éxito.',
                'success'
                )
        });



        //Mostrar Mensaje Eliminado con Éxito
        window.livewire.on('orden-eliminado', event => {
                swal(
                    '¡Orden de Servicio Eliminado!',
                    'La Orden de Servicio: "'+ @this.id_orden_de_servicio +'" fue Eliminado Exitosamente.',
                    'success'
                    )
            });

            
            
        //Mostrar Mensaje No se Puede Eliminar
        window.livewire.on('entregado-terminado', event => {
        swal("¡No se puede realizar esta acción!", "No se pueden Anular o Eliminar las Ordenes de Servicio que tengan Servicios Terminados o Entregados", {
						icon : "info",
						buttons: {        			
							confirm: {
								className : 'btn btn-info'
							}
						},
					});
            });

        //Mostrar Mensaje No se Puede Eliminar
        window.livewire.on('Serviciopendienteocupado', event => {
        swal("El Servicio ya cuenta con un Responsable Técnico", "Perdon pero el Servicio ya fué asignado a: " + @this.alert_responsabletecnico, {
						icon : "info",
						buttons: {        			
							confirm: {
								className : 'btn btn-info'
							}
						},
					});
            });


        //Mostrar Mensaje No puede Editar ni Terminar este Servicio porque no es el Técnico Responsable de este Servicio
        window.livewire.on('acceso-denegado', event => {
        swal("¡No puede realizar esta acción!", "No puede Editar o Terminar este Servicio por que no es el Técnico Responsble de este", {
						icon : "info",
						buttons: {        			
							confirm: {
								className : 'btn btn-info'
							}
						},
					});
            });

        //Crear pdf de Informe técnico de un servicio
        window.livewire.on('informe-tecnico', Msg => {
        var idservicio = @this.id_servicio;

        var win = window.open('informetecnico/pdf/' + idservicio);
        // Cambiar el foco al nuevo tab (punto opcional)
        // win.focus();

        });

    });



    // Código para lanzar la Alerta de Hacerse Técnico Responsable de un Servicio
    function ConfirmarTecnicoResponsable(codigo, nombrecliente, idservicio) {
        swal({
            title: '¿Quieres ser Responsable Técnico de la Orden de Servicio "' + codigo + '"?',
            text: "Seras Responsble de un  Servicio del Cliente: " + nombrecliente,
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Estoy de Acuerdo',
            padding: '2em'
            }).then(function(result) {
            if (result.value) {
                window.livewire.emit('sertecnicoresponsable', codigo, idservicio)
                }
            })
    }
    


    // Código para lanzar la Alerta de Anulación de Servicio
    function ConfirmarAnular(codigo, nombrecliente) {
        swal({
            title: '¿Anular la Órden de Servicio "' + codigo + '"?',
            text: "Cliente: " + nombrecliente,
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Anular Servicio',
            padding: '2em'
            }).then(function(result) {
            if (result.value) {
                window.livewire.emit('anularservicio', codigo)
                }
            })
    }
    

    // Código para lanzar la Alerta de Eliminación del Servicio
    function ConfirmarEliminar(codigo, nombrecliente) {
        swal({
            title: '¿Eliminar la Orden de Servicio "' + codigo + '"?',
            text: "Correspondiente al Cliente " + nombrecliente + ", esta acción es irreversible",
            type: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Eliminar Servicio',
            padding: '2em'
            }).then(function(result) {
            if (result.value) {
                window.livewire.emit('eliminarservicio', codigo)
                }
            })
    }
    



            



</script>
<!-- Scripts para el mensaje de confirmacion arriba a la derecha Categoría Creada con Éxito y Alerta de Eliminacion -->
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- Fin Scripts -->
@endsection