

@section('css')
<!-- Estilo ventas Switches en Ventas -->
<link href="{{ asset('assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-select/bootstrap-select.min.css') }}">

<link href="assets/css/scrollspyNav.css" rel="stylesheet" type="text/css" />
<link href="assets/css/components/tabs-accordian/custom-accordions.css" rel="stylesheet" type="text/css" />
@endsection
<div class="row sales layout-top-spacing">
    <div class="col-sm-12" >

        
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <p class=""> <h3>Devoluciones</h3> </p>
                </ul>
                <ul class="tabs tab-pills">
                    {{-- <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal"
                        data-target="#theModal">Devolución Por Venta</a> --}}
                        
                    <a href="javascript:void(0)" type="button" class="btn btn-info mb-2 mr-2" data-toggle="modal" data-target="#tabsModal">
                    Devolución Por Producto</a>
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
                            <h6>Seleccionar Usuario</h6>
                        </div>
                        <select wire:model="usuarioseleccionado" class="form-control">
                            @foreach ($listausuarios as $u)
                            <option value="{{$u->id}}">{{$u->nombreusuario}}</option>
                            @endforeach
                            <option value="Todos" selected>Todos los Usuarios</option>
                        </select>
                </div>
                @endif


            </div>

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mt-2">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-withe text-center">No</th>
                                <th class="table-th text-withe text-center">Imagen Producto</th>
                                <th class="table-th text-withe text-left">Nombre Producto</th>
                                <th class="table-th text-withe text-right">Monto Devuelto</th>
                                <th class="table-th text-withe text-center">Fecha Devolución</th>
                                <th class="table-th text-withe text-center">ARTÍCULO DEVUELTO</th>
                                <th class="table-th text-withe text-center">Usuario</th>
                                <th class="table-th text-withe text-center">Motivo</th>
                                <th class="table-th text-withe text-center">Estado</th>
                                @if($this->verificarpermiso() == true)
                                <th class="table-th text-withe text-center">Acción</th>
                                <th class="table-th text-withe text-center">Eliminar</th>
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
                                    <td class="text-center">
                                        <span>
                                            <img src="{{('storage/productos/'.$item->image) }}"
                                                height="40" class="rounded">
                                        </span>
                                    </td>
                                    <td class="text-left">
                                        <h6>{{ $item->nombre }}</h6>
                                    </td>
                                    <td class="text-right">
                                        <h6>{{ $item->monto }} Bs</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{  $this->cambiarformatofecha($item->fechadevolucion)  }}</h6>
                                    </td>
                                    <td>
                                        @if($item->tipo == 'MONETARIO')
                                        <h6 style="color: chocolate" class="text-center">{{ $item->tipo }}</h6>
                                        @else
                                        <h6 style="color: rgb(6, 21, 179)" class="text-center">{{ $item->tipo }}</h6>
                                        @endif
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $item->nombreusuario }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $item->observacion }}</h6>
                                    </td>
                                    <td>
                                        @if($item->estado == 'NORMAL')
                                        <h6 style="color: aqua" class="text-center">{{ $item->estado }}</h6>
                                        @else
                                            @if($item->estado == 'ELIMINADO')
                                            <h6 style="color: red" class="text-center">{{ $item->estado }}</h6>
                                            @else
                                            <h6 style="color: rgb(0, 209, 49)" class="text-center">{{ $item->estado }}</h6>
                                            @endif
                                        @endif
                                    </td>
                                    @if($this->verificarpermiso() == true)
                                    <td class="text-center">
                                        <a href="javascript:void(0)"
                                        onclick="Confirm('{{ $item->id }}')"
                                        class="btn btn-dark" title="Eliminar Devolución">
                                                <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                    <td>
                                        
                                        <button class="btn btn-dark">
                                            Transferir Producto
                                        </button>
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
                                    <td class="text-center">
                                        <span>
                                            <img src="{{('storage/productos/'.$item->image) }}"
                                                height="40" class="rounded">
                                        </span>
                                    </td>
                                    <td class="text-left">
                                        <h6>{{ $item->nombre }}</h6>
                                    </td>
                                    <td class="text-right">
                                        <h6>{{ $item->monto }} Bs</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{  $this->cambiarformatofecha($item->fechadevolucion)  }}</h6>
                                    </td>
                                    <td>
                                        @if($item->tipo == 'MONETARIO')
                                        <h6 style="color: chocolate" class="text-center">{{ $item->tipo }}</h6>
                                        @else
                                        <h6 style="color: rgb(6, 21, 179)" class="text-center">{{ $item->tipo }}</h6>
                                        @endif
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $item->nombreusuario }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $item->observacion }}</h6>
                                    </td>
                                    <td>
                                        @if($item->estado == 'NORMAL')
                                        <h6 style="color: rgb(29, 134, 148)" class="text-center">{{ $item->estado }}</h6>
                                        @else
                                            @if($item->estado == 'ELIMINADO')
                                            <h6 style="color: red" class="text-center">{{ $item->estado }}</h6>
                                            @else
                                            <h6 style="color: rgb(0, 209, 49)" class="text-center">{{ $item->estado }}</h6>
                                            @endif
                                        @endif
                                    </td>
                                    @if($this->verificarpermiso() == true)
                                    <td class="text-center">
                                        <a href="javascript:void(0)"
                                        onclick="Confirm('{{ $item->id }}')"
                                        class="btn btn-dark" title="Eliminar Devolución">
                                                <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                    <td>
                                        
                                        <button class="btn btn-dark">
                                            Transferir Producto
                                        </button>
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

        </div>


        @include('livewire.sales.modaldevolucion')


    </div>
</div>



@section('javascript')


@endsection

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
            text: '¿Seguro que quiere eliminar esta Devolución? ',
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