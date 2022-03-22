<div class="col-lg-6">
    @if($BuscarProductoNombre != 0)
    
            <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">

                <table class="table table-bordered table-striped mt-1">
                    <thead class="text-white" style="background: #3b3f5c ">
                        <tr>
                            <th class="table-th text-center text-white">IMAGEN</th>
                            <th class="table-th text-left text-white">DESCRIPCIóN</th>
                            <th class="table-th text-right text-white">PRECIO</th>
                            {{-- <th width="12%" class="table-th text-center text-white">Stock</th> --}}
                            <th class="table-th text-center text-white">ACCIONES</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($datosnombreproducto as $p)
                        <tr>
                            {{-- Imagen Producto --}}
                            <td class="text-center">
                                <span>
                                    <img src="{{('storage/productos/'.$p->image) }}"
                                        height="40" class="rounded">
                                </span>
                            </td>
                            {{-- Descripciòn Producto --}}
                            <td>
                                <h6>{{ $p->nombre }}</h6>
                            </td>
                            {{-- Precio Producto--}}
                            <td class="text-right">
                                <h6>{{ $p->precio_venta }} Bs</h6>
                            </td>
                            {{-- Stock Disponible --}}
                            {{-- <td  class="text-center">
                                <h6>{{$p->stock}}</h6>
                            </td> --}}
                            {{-- Acciones --}}
                            <td class="text-center">
                                <button  wire:click="increaseQty({{ $p->id }})" class="btn btn-dark mbmobile">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
                        
    @else
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <h5 class="text-center text-muted">Para Buscar use el Cuadro: Buscar Productos...</h5>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    @endif
</div>