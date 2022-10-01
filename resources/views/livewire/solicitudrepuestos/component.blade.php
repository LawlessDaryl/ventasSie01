@section('css')
<style>
    /* Estilos para las tablas */
    .table-wrapper {
    width: 100%;/* Anchura de ejemplo */
    /*height: 750px;  Altura de ejemplo */
    /* overflow: auto; */
    }

    .table-wrapper table {
        border-collapse: separate;
        border-spacing: 0;
        border-left: 0.3px solid #007bff;
        border-bottom: 0.3px solid #007bff;
        width: 100%;
    }

    .table-wrapper table thead {
        position: -webkit-sticky; /* Safari... */
        position: sticky;
        top: 0;
        left: 0;
    }
    .table-wrapper table thead tr {
    /* background: #007bff; */
    /* color: white; */
    }
    /* .table-wrapper table tbody tr {
        border-top: 0.3px solid rgb(0, 0, 0);
    } */
    .table-wrapper table tbody tr:hover {
        background-color: #fff0c1a4;
    }
    .table-wrapper table td {
        border-top: 0.3px solid #007bff;
        padding-left: 10px;
        border-right: 0.3px solid #007bff;
    }


        /*Estilos para el Boton Pendiente en la Tabla*/
        .pendienteestilos {
        text-decoration: none !important; 
        background-color: rgb(161, 0, 224);
        cursor: pointer;
        color: white;
        border-color: rgb(161, 0, 224);
        border-radius: 5px;
        padding-top: 0px;
        padding-bottom: 0px;
        padding-left: 1px;
        padding-right: 1px;
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




    /*Estilos para el Boton Aceptado en la Tabla*/

    .aceptadoestilos {
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
    .aceptadoestilos:hover {
        color: rgb(255, 255, 255) !important; 
    }





    /*Estilos para el Boton Pendiente en la Tabla*/
    .compraestilos {
        text-decoration: none !important; 
        background-color: rgb(224, 101, 0);
        cursor: pointer;
        color: white;
        border-color: rgb(224, 101, 0);
        border-radius: 5px;
        padding-top: 2px;
        padding-bottom: 2px;
        padding-left: 2px;
        padding-right: 2px;
        box-shadow: none;
        border-width: 2px;
        border-style: solid;
        border-color: rgb(224, 101, 0);
        display: inline-block;
        }
        .compraestilos:hover {
        background-color: rgb(255, 255, 255);
        color: rgb(224, 101, 0);
        transition: all 0.4s ease-out;
        border-color: rgb(224, 101, 0);
        text-decoration: underline;
        -webkit-transform: scale(1.05);
        -moz-transform: scale(1.05);
        -ms-transform: scale(1.05);
        transform: scale(1.05);

    }





</style>
@endsection
<div class="row">
    <div class="col-12 text-center">
        <p class="h1">SOLICITUDES</p>
    </div>
    <div class="col-12">
        <div class="table-wrapper">
            <table>
                <thead class="text-center" style="background: #007bff; color: white;">
                    <tr class="text-center">
                        <th>No</th>
                        <th>ORDEN DE SERVICIO</th>
                        <th>TECNICO SOLICITANTE</th>
                        <th>FECHA SOLICITUD</th>
                        <th>TIEMPO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lista_solicitudes as $l)
                    <tr style="background-color: rgb(162, 237, 250);" class="text-center">
                        <td>
                            <B>{{$loop->iteration}}</B>
                        </td>
                        <td>
                            <span class="stamp stamp" style="background-color: #1572e8">
                                {{$l->codigo}}
                            </span>
                        </td>
                        <td>
                            <b>{{$l->nombresolicitante}}</b>
                        </td>
                        <td>
                           <b>{{ \Carbon\Carbon::parse($l->created_at)->format('d/m/Y H:i') }}</b>
                        </td>
                        <td>
                            @if($l->minutos >= 0)
                            <span class="stamp stamp" style="background-color: #007bdf">
                                Hace <b>{{$l->minutos}}</b> Minutos  
                            </span>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td>

                        </td>
                        <td class="text-center">
                            
                        </td>
                        <td>


                            <table style="font-size: 13px;">
                                <thead style="background-color: rgb(255, 255, 255);">
                                    <tr>
                                        <th class="text-center">
                                            <b>NOMBRE PRODUCTO</b>
                                        </th>
                                        <th class="text-center">
                                            <b>CANTIDAD</b>
                                        </th>
                                        <th class="text-center">
                                            <b>ESTANCIA</b>
                                        </th>
                                        <th class="text-center">
                                            <b>TIPO</b>
                                        </th>
                                        <th class="text-center">
                                            <b>ESTADO</b>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($l->detalles as $d)
                                        <tr>
                                            <td>
                                                {{$d->nombreproducto}}
                                            </td>
                                            <td class="text-center">
                                                {{$d->cantidad}}
                                            </td>
                                            <td class="text-center">
                                                {{$d->nombredestino}}
                                            </td>
                                            <td class="text-center">
                                                @if($d->tipo == "CompraRepuesto")
                                                
                                                <div style="background-color: rgb(206, 0, 0); color: white;">
                                                    Compra
                                                </div>

                                                @else
                                                {{$d->tipo}}
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($d->status == "PENDIENTE" && $d->tipo != "CompraRepuesto")
                                            


                                                <a href="#" onclick="ConfirmarCambiar({{ $d->iddetalle }})"  class="pendienteestilos" title="Aceptar Solicitud">
                                                    {{$d->status}}
                                                </a>




                                                @else

                                                <a href="#" class="aceptadoestilos">
                                                    {{$d->status}}
                                                </a>

                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>







                        </td>
                        <td class="text-center">
                            <button wire:click="generarcompra({{$l->codigo}})" class="compraestilos">
                                Generar Compra
                            </button>
                        </td>
                        <td>

                        </td>
                    </tr>



                    
                    @endforeach
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
    </div>
    @include('livewire.solicitudrepuestos.modalcomprarepuesto')
</div>
@section('javascript')





<script>
    document.addEventListener('DOMContentLoaded', function() {

        //Mostrar ventana modal comprar repuesto
        window.livewire.on('modalcomprarepuesto-show', msg => {
            $('#modalcomprarepuesto').modal('show')
        });


        //Mostrar cualquier tipo de Mensaje Ventana de Ok
        window.livewire.on('mensaje-ok', event => {
                swal(
                    '¡Solicitud Aceptada!',
                    @this.message,
                    'success'
                    )
            });


    });


    // Código para lanzar la Alerta de Cambiar el estado de una solicitud
    function ConfirmarCambiar(iddetalle) {
    swal({
        title: '¿Aceptar la Solicitud?',
        text: "Se registrará la solicitud como aceptada",
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Aceptar',
        padding: '2em'
        }).then(function(result) {
        if (result.value) {
            window.livewire.emit('aceptarsolicitud', iddetalle)
            }
        })
    }

</script>

<!-- Scripts para el mensaje de confirmacion arriba a la derecha 'Mensaje Toast' de Éxito y Alerta de Eliminacion -->
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- Fin Scripts -->

@endsection
