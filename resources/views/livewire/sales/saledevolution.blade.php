

@section('css')
<!-- Estilo ventas Switches en Ventas -->
<link href="{{ asset('assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-select/bootstrap-select.min.css') }}">


@endsection


<div class="row sales layout-top-spacing">
    <div class="col-sm-12" >

        
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <p class=""> <h3>Total Ventas: 0 Bs</h3> </p>
                </ul>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal"
                        data-target="#theModal">Devolución Por Venta</a>
                        
                    <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal" data-target="#devolucionProducto"
                    >Devolución Por Producto</a>
                </ul>
                
            </div>
            @include('common.searchbox')

            <div class="widget-content">

                <div class="widget-content widget-content-area">
                    <div>
                        <h6>Seleccionar Usuario</h6>
                    </div>
                    <select class="form-control">
                        <option>Emanuel</option>
                        <option>Alejandro</option>
                        <option>Ernesto</option>
                    </select>
                </div>

                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mt-2">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-withe text-center">No</th>
                                <th class="table-th text-withe text-center">Imagen Producto</th>
                                <th class="table-th text-withe text-left">Nombre Producto</th>
                                <th class="table-th text-withe text-right">Monto Bs</th>
                                <th class="table-th text-withe text-center">Fecha Devolución</th>
                                <th class="table-th text-withe text-center">Tipo</th>
                                <th class="table-th text-withe text-center">Usuario</th>
                                <th class="table-th text-withe text-center">Motivo</th>
                                <th class="table-th text-withe text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td class="text-center">
                                        x
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
                                        <h6 class="text-center">{{ $item->tipo }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">Nombre Usuario</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $item->observacion }}</h6>
                                    </td>

                                    <td class="text-center">
                                        <a href="javascript:void(0)" onclick="Confirm()" class="btn btn-dark" title="Delete">
                                                <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data->links() }}
                </div>
            </div>




















        </div>


        @include('livewire.sales.modalproducto')


    </div>
</div>



@section('javascript')

<script src="assets/js/scrollspyNav.js"></script>
<script src="plugins/bootstrap-select/bootstrap-select.min.js"></script>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('item-added', msg => {
            $('#theModal').modal('hide')
            noty(msg)
        });
        window.livewire.on('item-updated', msg => {
            $('#theModal').modal('hide')
            noty(msg)
        });
        window.livewire.on('item-deleted', msg => {
            noty(msg)
        });
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show')
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
        });
    });

    function Confirm(id, name, cantRelacionados ) {
        if (cantRelacionados > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No se puede eliminar el origen "' + name + '" porque tiene ' 
                + cantRelacionados + ' Origen-Motivo relacionado(s).'
            })
            return;
        }
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Confirmar eliminar el origen ' + '"' + name + '"?.',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('deleteRow', id)
                Swal.close()
            }
        })
    }
</script>