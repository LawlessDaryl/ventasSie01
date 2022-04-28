<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal"
                        data-target="#theModal">Agregar<br>Producto</a>
                </ul>
            </div>
            <div class="row">
                <div class="col-12 col-lg-4 col-md-6">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-gp">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                        <input type="text" wire:model="search" placeholder="Buscar" class="form-control">
                    </div>
                </div>
                <div class="col-12 col-lg-2 col-md-3">
                    <div class="form-group">
                        <select wire:model='selected_categoria' class="form-control">
                          <option value="null">Elegir Categoria</option>
                          @foreach ($categories as $dats)
                          <option value="{{ $dats->id }}">{{ $dats->name}}</option>
                          @endforeach
                       
                         
                        </select>
                      </div>
                    
                </div>
                <div class="col-12 col-lg-2 col-md-3">

                    <div class="form-group">
                        <select wire:model='selected_sub' class="form-control">
                          <option value="null">Elegir Categoria</option>
                          @foreach ($subcat as $dat)
                          <option value="{{ $dat->id }}">{{ $dat->name}}</option>
                          @endforeach
                       
                         
                        </select>
                      </div>
                </div>
            </div>
         

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mt-4">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-withe"> <b>#</b> </th>
                                <th class="table-th text-withe"> <b>NOMBRE</b> </th>
                                <th class="table-th text-withe text-center"> <b>CARACTERISTICAS</b> </th>
                                <th class="table-th text-withe text-center"> <b>PRECIO</b> </th>
                                <th class="table-th text-withe text-center"> <b>STATUS</b> </th>
                                <th class="table-th text-withe text-center"> <b>IMAGEN</b> </th>
                                <th class="table-th text-withe text-center"> <b>ACCIONES</b> </th>
                            </tr>
                        </thead>
                        <tbody id="imprimible" >
                            @foreach ($data as $product)
                                <tr>
                                    <td>
                                        <h6>{{ $nro++}}</h6>
                                    </td>
                                    <td>
                                        <h6>{{ $product->nombre }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $product->caracteristicas }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center">{{ $product->precio_venta }}</h6>
                                    </td>
                                    <td>
                                        <h6 class=" text-center">{{ $product->stock }}</h6>
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
                                            class="btn btn-dark mtmobile p-1 m-0" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                            onclick="Confirm('{{ $product->id }}','{{ $product->nombre }}')"
                                            class="btn btn-dark mtmobile p-1 m-0" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <a href="javascript:void(0)" id="btnImprimir" onclick="imprimirElemento()"
                                            class="btn btn-dark mtmobile p-1 m-0" title="Edit">
                                            <i class="fas fa-barcode"></i>
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

    document.querySelector("#btnImprimir").addEventListener("click", function() {
                var div = document.querySelector("#imprimible");
                imprimirElemento(div);
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
    function imprimirElemento(elemento){
            var ventana = window.open('', 'PRINT', 'height=400,width=600');
            ventana.document.write('<html><head><title>' + document.title + '</title>');
            ventana.document.write('</head><body >');
            ventana.document.write(elemento.innerHTML);
            ventana.document.write('</body></html>');
            ventana.document.close();
            ventana.focus();
            ventana.print();
            ventana.close();
            return true;
}
</script>
