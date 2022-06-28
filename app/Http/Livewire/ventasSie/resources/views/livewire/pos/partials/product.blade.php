<div class="col-lg-4">
    @if($BuscarProductoNombre != 0)
    
    <div class="table-wrapper">
        {{-- <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar"> --}}

            <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                <thead>
                <tr>
                    <th class="table-th text-left text-white">DESCRIPCION</th>
                    <th class="table-th text-right text-white">PRECIO</th>
                    {{-- <th width="12%" class="table-th text-center text-white">Stock</th> --}}
                    <th class="table-th text-center text-white" style="max-height: 10px;">ACCION</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach ($datosnombreproducto as $p)
                <tr>
                    {{-- Descripciòn Producto --}}
                    <td>
                        <h6>{{ $p->nombre }}</h6>
                        <h6><b>({{ $p->barcode }})</b></h6>
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
                    <td class="text-center" style="max-height: 10px;">
                        <button  wire:click="pasaralcarrito({{ $p->id }})" class="btn btn-sm" style="background-color: rgb(10, 137, 235); color:aliceblue">
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