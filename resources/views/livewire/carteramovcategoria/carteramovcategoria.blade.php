@section('css')

<style>
    /* Estilos para las tablas */
    .table-wrapper {
    width: 100%;/* Anchura de ejemplo */
    height: 500px; /* Altura de ejemplo */
    overflow: auto;
    }

    .table-wrapper table {
        border-collapse: separate;
        border-spacing: 0;
        border-left: 0.3px solid #02b1ce;
        border-bottom: 0.3px solid #02b1ce;
        width: 100%;
    }

    .table-wrapper table thead {
        position: -webkit-sticky; /* Safari... */
        position: sticky;
        top: 0;
        left: 0;
    }
    .table-wrapper table thead tr {
    background: #02b1ce;
    color: white;
    }
    /* .table-wrapper table tbody tr {
        border-top: 0.3px solid rgb(0, 0, 0);
    } */
    .table-wrapper table tbody tr:hover {
        background-color: #ffdf76a4;
    }
    .table-wrapper table td {
        border-top: 0.3px solid #02b1ce;
        padding-left: 10px;
        border-right: 0.3px solid #02b1ce;
    }

</style>
@endsection
<div>
    <div class="text-center">
        <h2><b>Categoria Cartera Movimiento</b></h2>
    </div>

    <br>
    <div class="text-right">
        <button wire:click="modalnuevacategoria()" type="button" class="btn btn-warning">Nueva Categoria</button>
    </div>
    <br>



    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nombre Categoria</th>
                    <th class="text-center">Detalles</th>
                    <th class="text-center">Tipo</th>
                    <th class="text-center">Estado</th>
                    <th class="text-center">Fecha Creación</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $p)
                <tr>
                    <td class="text-center">
                        {{ ($data->currentpage()-1) * $data->perpage() + $loop->index + 1 }}
                    </td>
                    <td class="text-center">
                        {{ $p->nombre }}
                    </td>
                    <td class="text-center">
                        {{ $p->detalle }}
                    </td>
                    <td class="text-center">
                        {{ $p->tipo }}
                    </td>
                    <td class="text-center">
                        @if($p->status == "ACTIVO")
                        <div style="color: rgb(0, 20, 204);">
                            {{ $p->status }}
                        </div>
                        @else
                        <div style="color: rgb(243, 0, 0);">
                            {{ $p->status }}
                        </div>
                        @endif
                    </td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($p->created_at)->format('d/m/Y H:i') }}
                    </td>
                    <td class="text-center">
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            @if($p->status == "ACTIVO")
                            <button wire:click.prevent="modaleditar({{$p->id}})" title="Editar Categoria" type="button" class="btn btn-outline-primary">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="ConfirmarAnular({{ $p->id }},'{{ $p->nombre }}')" title="Anular Categoria" type="button" class="btn btn-outline-danger">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            @else
                            <button wire:click.prevent="reacctivar({{$p->id}})" type="button" title="Reactivar Categoria" class="btn btn-outline-info">
                                <i class="fab fa-phabricator"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $data->links() }}
    @include('livewire.carteramovcategoria.modalnuevacategoria')



</div>
@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Mètodo JavaScript para llamar al modal para crear o actualizar categorias
        window.livewire.on('nuevacategoria-show', Msg => {
            $("#modalnuevacategoria").modal("show");
        });
        //Cierra la ventana Modal Buscar Cliente y muestra mensaje Toast cuando se selecciona un Cliente
        window.livewire.on('nuevacategoria-hide', msg => {
            $("#modalnuevacategoria").modal("hide");
            const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            padding: '2em'
            });
            toast({
                type: 'success',
                title: @this.mensaje_toast,
                padding: '2em',
            })
        });


        //Mostrar Mensaje Toast de Éxito
        window.livewire.on('accion-ok', event => {
        swal(
            '¡Anulado!',
            'La Categoria: "'+ @this.mensaje_toast +'" fue anulado con éxito.',
            'success'
            )
        });


        window.livewire.on('accion-toast-ok', event => {
            const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            padding: '2em'
            });
            toast({
                type: 'success',
                title: @this.mensaje_toast,
                padding: '2em',
            })
        });




    });





    // Código para lanzar la Alerta de Anulación de Servicio
    function ConfirmarAnular(id, nombrecategoria) {
        swal({
        title: '¿Anular la Categoria "' + nombrecategoria + '"?',
        text: "Nombre Categoria: " + nombrecategoria,
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Anular Categoria',
        padding: '2em'
        }).then(function(result) {
        if (result.value) {
            window.livewire.emit('anularcategoria', id)
            }
        })
    }
    


</script>


<!-- Scripts para el mensaje de confirmacion arriba a la derecha 'Mensaje Toast' de Éxito y Alerta de Eliminacion -->
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- Fin Scripts -->
@endsection