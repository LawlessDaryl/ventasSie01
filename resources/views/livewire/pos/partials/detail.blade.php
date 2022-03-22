<div class="col-lg-6">
    @if ($total > 0)

    <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">

        <table class="table table-bordered table-striped mt-1">
            <thead class="text-white" style="background: #3b3f5c ">
                <tr>
                    <th class="table-th text-left text-white">IMAGEN</th>
                    <th class="table-th text-left text-white">DESCRIPCIóN</th>
                    <th class="table-th text-center text-white">PRECIO</th>
                    <th width="12%" class="table-th text-center text-white">CANTIDAD</th>
                    <th class="table-th text-center text-white">IMPORTE</th>
                    <th class="table-th text-center text-white">ACCIONES</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $item)
                <tr>
                    {{-- Imagen Producto --}}
                    <td class="text-center">
                        @if (count($item->attributes) > 0)
                        <span>
                            <img src="{{ asset('storage/productos/' . $item->attributes[0]) }}" alt="imágen del producto" height="40" class="rounded">
                        </span>
                        @endif
                    </td>
                    {{-- Descripciòn Producto --}}
                    <td>
                        <h6>{{ $item->name }}</h6>
                    </td>
                    {{-- Precio --}}
                    <td class="text-center">${{ number_format($item->price, 2) }}</td>
                    {{-- Cantidad --}}
                    <td>
                        <input type="number" maxlength="{{$item->stock}}"
                        id="r{{$item->id}}" 
                        wire:change="UpdateQty({{$item->id}}, $('#r' + {{$item->id}}).val() )" 
                        style="font-size: 1rem!important;" 
                        class="form-control text-center" 
                        value="{{$item->quantity}}">
                    </td>
                    {{-- Importe --}}
                    <td class="text-center">
                        <h6>{{ $item->price * $item->quantity, 2 }}</h6>
                    </td>
                    {{-- Acciones --}}
                    <td class="text-center">
                        <button onclick="Confirm('{{ $item->id }}','removeItem','¿Confirmas eliminar el Registro?')" class="btn btn-dark mbmobile">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                        <button wire:click.prevent="decreaseQty({{ $item->id }})" class="btn btn-dark mbmobile">
                            <i class="fas fa-minus"></i>
                        </button>

                        <button wire:click.prevent="increaseQty({{ $item->id }})" class="btn btn-dark mbmobile">
                            <i class="fas fa-plus"></i>
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
            
        <h5 class="text-center text-muted">Agregar productos a la venta</h5>

            <br>
            <br>
            <br>
            <br>
            <br>
            <br>}
        @endif
        <div wire:loading.inline wire:target="saveSale">
            <h4 class="text-danger text-center">Guardando venta...</h4>
        </div>
</div>