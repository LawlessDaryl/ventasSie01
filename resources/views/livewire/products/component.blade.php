<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-warning" data-toggle="modal"
                        data-target="#theModal">Agregar</a>
                </ul>
            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mt-4">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-withe">NOMBRE</th>
                                <th class="table-th text-withe text-center">BARCODE</th>
                                <th class="table-th text-withe text-center">PRECIO</th>
                                <th class="table-th text-withe text-center">STOCK</th>
                                <th class="table-th text-withe text-center">INV.MIN</th>
                                <th class="table-th text-withe text-center">STATUS</th>
                                <th class="table-th text-withe text-center">IMAGEN</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $product)
                                <tr>
                                    <td>
                                        <h6>{{ $product->nombre }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $product->barcode }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $product->precio_venta }}</h6>
                                    </td>
                                    <td>
                                        <h6 class=" text-center">{{ $product->stock }}</h6>
                                    </td>

                                    <td>
                                        <h6 class="text-center">{{ $product->cantidad_minima }}</h6>
                                    </td>

                                    <td>
                                        <h6 class="text-center">{{ $product->status }}</h6>
                                    </td>
                                    

                                    <td class="text-center">
                                        <span>
                                            <img src="{{('storage/productos/'.$product->imagen) }}"
                                                alt="imagen de ejemplo" height="40" width="50" class="rounded">
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $product->id }})"
                                            class="btn btn-warning mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                            onclick="Confirm('{{ $product->id }}','{{ $product->nombre }}')"
                                            class="btn btn-warning" title="Delete">
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
    </div>
    @include('livewire.products.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {


        window.livewire.on('product-added', msg => {
            $('#theModal').modal('hide'),
            noty(msg)
        });
        window.livewire.on('product-updated', msg => {
            $('#theModal').modal('hide')
            noty(msg)
        });
        window.livewire.on('product-deleted', msg => {
            noty(msg)
        });
        window.livewire.on('modal-show', msg => {
            $('#theModal').modal('show')
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
        });
        window.livewire.on('hidden.bs.modal', function(e) {
            $('.er').css('display', 'none')
        });
    });

    function Confirm(id, name, products) {
        if (products > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No se puede eliminar el producto, ' + name + ' porque tiene ' +
                    products + ' ventas relacionadas'
            })
            return;
        }
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar el prouducto ' + '"' + name + '"',
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
