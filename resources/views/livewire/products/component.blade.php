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
                        <input type="text" wire:model="search" placeholder="Buscars" class="form-control">
                    </div>
                </div>
                <div class="col-12 col-lg-3 col-md-3">
                    <div class="form-group">
                        <select wire:model='selected_categoria' class="form-control">
                          <option value="null" disabled>Elegir Categoria</option>
                          @foreach ($categories as $key => $category)
                          <option value="{{ $category->id }}">{{ $category->name}}-{{$category->id}}-{{$key}}</option>
                          @endforeach
                        </select>
                      </div>
                </div>
                <div class="col-12 col-lg-3 col-md-3">
                    <div class="form-group">
                        <select wire:model='selected_sub' class="form-control">
                          <option value="null" disabled>Elegir Subcategoria</option>
                          @foreach ($sub as $subcategoria)
                          <option value="{{ $subcategoria->id }}">{{ $subcategoria->name}}</option>
                          @endforeach
                        </select>
                      </div>
                </div>
                <div class="col-12 col-lg-2 col-md-3">
                    <div class="form-group">
                        <select wire:model='estados' class="form-control">
                          <option value="null" disabled>Estado</option>
                          <option value="ACTIVO">ACTIVO</option>
                          <option value="INACTIVO">INACTIVO</option>
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
                                <th class="table-th text-withe" style="width: 20%"> <b>NOMBRE</b> </th>
                                <th class="table-th text-withe text-center"> <b>CATEGORIA</b> </th>
                                <th class="table-th text-withe text-center"> <b>CODIGO/<br>CODIGO BARRA</b></th>
                                <th class="table-th text-withe text-center"> <b>PRECIO</b> </th>
                                <th class="table-th text-withe text-center"> <b>STATUS</b> </th>
                                <th class="table-th text-withe text-center"> <b>IMAGEN</b> </th>
                                <th class="table-th text-withe text-center"> <b>ACCIONES</b> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $products)
                                <tr>
                                    <td>
                                        <h6>{{$nro++}}</h6>
                                    </td>
                                    <td>
                                        <h5> <strong>{{$products->nombre}}</strong> </h5>
                                        <label>{{ $products->unidad}}</label>|<label>{{ $products->marca}}</label>|<label>{{ $products->industria }}</label>
                                        <h6>{{ $products->caracteristicas }}</h6>

                                    </td>
                                    @if ($products->category->subcat == null)
                                    <td>
                                        <h6 class="text-center"> <strong>Categoria:</strong> {{ $products->category->name}}</h6>
                                        <h6 class="text-center"> <strong>Subcategoria:</strong>No definido</h6>
                                   </td>
                                    @else
                                    <td>
                                        <h6 class="text-center"> <strong>Categoria:</strong> {{ $products->category->subcat->name}}</h6>
                                        <h6 class="text-center"> <strong>Subcategoria:</strong>{{ $products->category->name}}</h6>
                                   </td>
                                    @endif
                                    <td>
                                         <h6 class="text-center">{{ $products->category->categoria_padre}}-{{ $products->category->id}}</h6>
                                    </td>
                                    <td>
                                         <h6 class="text-center">{{ $products->codigo}}</h6>
                                    </td>
                                    <td>
                                        <h6 class="text-center"> <strong>Costo:</strong> {{ $products->costo}}</h6>
                                        <h6 class="text-center"> <strong>Precio:</strong> {{ $products->precio_venta }}</h6>
                                    </td>
                                    @if ($products->status == "ACTIVO")
                                    <td style="background-color: rgb(100, 175, 25)">
                                        <h6 class=" text-center  text-white"> <strong>{{ $products->status }}</strong> </h6>
                                    </td>
                                    @else
                                    <td style="background-color: rgb(231, 59, 88)">
                                        <h6 class=" text-center text-white"> <strong>{{ $products->status }}</strong></h6>
                                    </td>
                                    @endif
                                    
                                    <td class="text-center">
<<<<<<< HEAD
                                       {{-- <span>
=======
                                        {{-- <span>
>>>>>>> 1ec20fbd571562b1c035ddb94fef968dcae8c1d9
                                            <img src="{{('storage/productos/'.$product->imagen) }}"
                                                alt="imagen de ejemplo" height="40" class="rounded">
                                        </span> --}}
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" wire:click="Edit({{ $products->id }})"
                                            class="btn btn-dark mtmobile p-1 m-0" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="javascript:void(0)"
                                            onclick="Confirm('{{ $products->id }}','{{ $products->nombre }}',{{$products->destinos->count()}})"
                                            class="btn btn-dark mtmobile p-1 m-0" title="Delete">
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
        if (products > 0)
        {
            console.log(products);
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'El producto' + name + ' tiene relacion con otros registros del sistema, desea proseguir con la eliminacion de este ITEM?',
                showCancelButton: true,
                cancelButtonText: 'Cerrar',
                cancelButtonColor: '#383838',
                confirmButtonColor: '#3B3F5C',
                confirmButtonText: 'Aceptar'
            }).then(function(result){
            if (result.value) {
                window.livewire.emit('deleteRow', id)
                Swal.close()
            }
        })
            
            //este producto tiene varias relaciones activas con otros registros del sistema
        }

        else{
            swal.fire({
                title: 'CONFIRMAR',
                icon: 'warning',
                text: 'Este producto no tiene relacion con ningun registro del sistema, pasara a ser eliminado permanentemente. ',
                showCancelButton: true,
                cancelButtonText: 'Cerrar',
                cancelButtonColor: '#383838',
                confirmButtonColor: '#3B3F5C',
                confirmButtonText: 'Aceptar'
            }).then(function(result){
                if(result.value){
                    window.livewire.emit('deleteRowPermanently',id).Swal.close()
                }
            })
        }
       
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
