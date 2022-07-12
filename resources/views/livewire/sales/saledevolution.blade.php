

@section('css')
<style>
    /* Estilos para las tablas */
    .table-wrapper {
    width: 100%;/* Anchura de ejemplo */
    height: 200px; /* Altura de ejemplo */
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

    .table-wrapper table thead th {
    border: 1px solid #000;
    background: #ee761c;
    }
    .table-wrapper table tbody td {
    border: 1px solid #000;
    }


    




























    .table-wrapper2 {
    width: 100%;/* Anchura de ejemplo */
    height: 575px; /* Altura de ejemplo */
    overflow: auto;
    }

    .table-wrapper2 table {
    border-collapse: separate;
    border-spacing: 0;
    }

    .table-wrapper2 table thead {
    position: -webkit-sticky; /* Safari... */
    position: sticky;
    top: 0;
    left: 0;
    }

    .table-wrapper2 table thead th {
    border: 1px solid #000;
    background: #ee761c;
    }
    .table-wrapper2 table tbody td {
    border: 1px solid #000;
    }


</style>


@endsection
<div class="row layout-top-spacing" id="cancel-row">

    <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
        <div class="widget-content widget-content-area br-6">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="text-right">
                    {{-- <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal"
                        data-target="#theModal">Devolución Por Venta</a> --}}
                        
                    <a href="javascript:void(0)" type="button" class="btn btn-info mb-2 mr-2" data-toggle="modal" data-target="#tabsModal">
                    Nueva Devolución</a>
                </ul>
                
            </div>

            <div class="row text-center">
                            
                <div class="col-lg-10 col-md-12 col-sm-12">
                    <br>
                    @include('common.searchbox')
                </div>


                @if($this->verificarpermiso() == true)
                <div class="col-lg-2 col-md-12 col-sm-12">
                        <div>
                            Seleccionar Usuario
                        </div>
                        <select wire:model="usuarioseleccionado" class="form-control">
                            <option value="Todos" selected>Todos los Usuarios</option>
                            @foreach ($listausuarios as $u)
                            <option value="{{$u->id}}">{{$u->nombreusuario}}</option>
                            @endforeach
                        </select>
                </div>
                @endif


            </div>

            <div class="table-responsive mb-4 mt-4">
                <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4" style="min-width: 1000px;">
                    <thead class="text-white" style="background: #ee761c">
                        <tr>
                            <th class="table-th text-withe text-center">No</th>
                            <th class="table-th text-withe text-center">Fecha</th>
                            <th class="table-th text-withe text-left">Nombre</th>
                            <th class="table-th text-withe text-center">Cartera</th>
                            <th class="table-th text-withe text-center">Monto</th>
                            <th class="table-th text-withe text-center">Locacion</th>
                            <th class="table-th text-withe text-center">Artículo Devuelto</th>
                            <th class="table-th text-withe text-center">Usuario</th>
                            <th class="table-th text-withe text-center">Motivo</th>
                            {{-- <th class="table-th text-withe text-center">Estado</th> --}}
                            @if($this->verificarpermiso() == true)
                            <th class="table-th text-withe text-center">Acción</th>
                            {{-- <th class="table-th text-withe text-center">Eliminar</th> --}}
                            @endif
                        </tr>
                    </thead>

                    @if($usuarioseleccionado == "Todos")
                    <tbody>
                        @foreach ($data as $item)
                            
                            <tr>
                                <td class="text-center">
                                    {{$loop->iteration}}
                                </td>
                                <td>
                                    {{$item->fechadevolucion}}
                                </td>
                                <td class="text-left">
                                    {{ $item->nombre }}
                                </td>
                                <td class="text-center">
                                    @if($item->tipo == 'PRODUCTO')
                                    No Corresponde
                                    @else
                                    {{ $item->cartera }}
                                    @endif
                                </td>
                                <td class="text-right">
                                    {{ $item->monto }} Bs
                                </td>
                                <td>
                                    {{  $item->destino  }}
                                </td>
                                <td>
                                    @if($item->tipo == 'MONETARIO')
                                    <h6 style="color: chocolate" class="text-center">{{ $item->tipo }}
                                    @else
                                    <h6 style="color: rgb(6, 21, 179)" class="text-center">{{ $item->tipo }}
                                    @endif
                                </td>
                                <td>
                                    {{ $item->nombreusuario }}
                                </td>
                                <td>
                                    {{ $item->observacion }}
                                </td>
                                {{-- <td>
                                    @if($item->estado == 'NORMAL')
                                    <h6 style="color: rgb(50, 0, 131)" class="text-center">{{ $item->estado }}
                                    @else
                                    <h6 style="color: rgb(0, 209, 49)" class="text-center">{{ $item->estado }}
                                    @endif
                                </td> --}}
                                @if($this->verificarpermiso() == true)
                                    <td class="text-center">
                                        @if(\Carbon\Carbon::parse($item->fechadevolucion)->format('d/m/Y') == date('d/m/Y'))
                                            <button href="javascript:void(0)"
                                            onclick="Confirm('{{ $item->iddevolucion }}')"
                                            class="btn btn-sm" title="Eliminar Devolución" style="background-color: red; color:white">
                                                    <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                    @else
                    <tbody>
                        @foreach ($usuarioespecifico as $item)
                            <tr>
                                <td class="text-center">
                                    {{$loop->iteration}}
                                </td>
                                <td>
                                    {{$item->fechadevolucion}}
                                </td>
                                <td class="text-left">
                                    {{ $item->nombre }}
                                </td>
                                <td class="text-center">
                                    @if($item->tipo == 'PRODUCTO')
                                    No Corresponde
                                    @else
                                    {{ $item->cartera }}
                                    @endif
                                </td>
                                <td class="text-right">
                                    {{ $item->monto }} Bs
                                </td>
                                <td>
                                    {{  $item->destino  }}
                                </td>
                                <td>
                                    @if($item->tipo == 'MONETARIO')
                                    <h6 style="color: chocolate" class="text-center">{{ $item->tipo }}
                                    @else
                                    <h6 style="color: rgb(6, 21, 179)" class="text-center">{{ $item->tipo }}
                                    @endif
                                </td>
                                <td>
                                    {{ $item->nombreusuario }}
                                </td>
                                <td>
                                    {{ $item->observacion }}
                                </td>
                                {{-- <td>
                                    @if($item->estado == 'NORMAL')
                                    <h6 style="color: rgb(29, 134, 148)" class="text-center">{{ $item->estado }}
                                    @else
                                        @if($item->estado == 'ELIMINADO')
                                        <h6 style="color: red" class="text-center">{{ $item->estado }}
                                        @else
                                        <h6 style="color: rgb(0, 209, 49)" class="text-center">{{ $item->estado }}
                                        @endif
                                    @endif
                                </td> --}}
                                @if($this->verificarpermiso() == true)
                                <td class="text-center">
                                    @if(\Carbon\Carbon::parse($item->fechadevolucion)->format('d/m/Y') == date('d/m/Y'))
                                    <button href="javascript:void(0)"
                                    onclick="Confirm('{{ $item->iddevolucion }}')"
                                    class="btn btn-sm" title="Eliminar Devolución" style="background-color: red; color:white">
                                            <i class="fas fa-trash"></i>
                                    </button>
                                    @endif
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                    @endif
                </table>
                @if($usuarioseleccionado == "Todos")
                {{ $data->links() }}
                @else
                {{ $usuarioespecifico->links() }}
                @endif
            </div>
        </div>
        @include('livewire.sales.modaldevolucion')
    </div>
</div>



@section('javascript')


<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('item-deleted', msg => {
            noty(msg)
        });
    });
    function Confirm(id)
    {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Seguro que quiere Eliminar esta Devolución? Se reventiran todos los cambios guardados',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('eliminardevolucion', id)
                Swal.close()
            }
        })
    }
    function hola()
    {
        alert("HOLA");
    }
</script>

@endsection