<div class="col-lg-6">
    @if($BuscarProductoNombre != 0)
    
    <div class="table-responsive table-wrapper-scroll-y">
        {{-- <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar"> --}}

            <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                <thead class="text-white" style="background: #ee761c">
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
                        {{ $p->precio_venta }} Bs
                    </td>
                    {{-- Stock Disponible --}}
                    {{-- <td  class="text-center">
                        <h6>{{$p->stock}}</h6>
                    </td> --}}
                    {{-- Acciones --}}
                    <td class="text-center">
                        <button  wire:click="pasaralcarrito({{ $p->id }})" class="btn btn-warning btn-sm">
                            <i class="fas fa-plus"></i>
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
    <br>
    <br>

    <h5 class="text-center text-muted">PARA BUSCAR USE EL CUADRO: BUSCAR PRODUCTOS...</h5>

    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    @endif
</div>