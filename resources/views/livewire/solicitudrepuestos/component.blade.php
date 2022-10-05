@section('css')
<style>

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

    <div class="col-12 col-sm-6 col-md-3 text-center">
        <b>XXXXXXXX</b>
        <div class="form-group">

        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-3 text-center">
        <b>XXXXXXX</b>
        <div class="form-group">
            
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3 text-center">
        <b>XXXXXX</b>
        <div class="form-group">
            
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3 text-center">
        <b>|</b>
        <div class="form-group">
            <button wire:click="modal_iniciar_compra2()" type="button" class="btn btn-primary">Generar Órden de Compra</button>
        </div>
    </div>



    <div class="col-12">
        <div class="table-1">
            <table>
                <thead class="text-center" style="background: #02b1ce; color: white;">
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
                            <span class="stamp stamp" style="background-color: #02b1ce">
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
                                                
                                                <div style="background-color: rgb(255, 82, 82); color: white;">
                                                    Compra
                                                </div>

                                                @else
                                                {{$d->tipo}}
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($d->estado == "PENDIENTE" && $d->tipo != "CompraRepuesto")

                                                <a href="#" onclick="ConfirmarCambiar({{ $d->iddetalle }}, {{$l->codigo}})"  class="pendienteestilos" title="Aceptar Solicitud">
                                                    {{$d->estado}}
                                                </a>

                                                @else

                                                    @if($d->estado == "ACEPTADO")

                                                        <a href="#" class="aceptadoestilos">
                                                            {{$d->estado}}
                                                        </a>

                                                    @else

                                                        @if($d->estado == "COMPRANDO")

                                                        <a href="#" class="">
                                                            {{$d->estado}}
                                                        </a>

                                                        @endif
                                                    
                                                    @endif

                                                

                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>


                        </td>
                        <td class="text-center">
                            
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
        //Ocultar ventana modal comprar repuesto
        window.livewire.on('modalcomprarepuesto-hide', msg => {
            $('#modalcomprarepuesto').modal('hide')
            swal(
            '¡Compra Enviada!',
            @this.message,
            'success'
            )
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
    function ConfirmarCambiar(iddetalle, codigo) {
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
            window.livewire.emit('aceptarsolicitud', iddetalle, codigo)
            }
        })
    }

</script>

<!-- Scripts para el mensaje de confirmacion arriba a la derecha 'Mensaje Toast' de Éxito y Alerta de Eliminacion -->
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- Fin Scripts -->

@endsection
