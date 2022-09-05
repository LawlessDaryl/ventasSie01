<div class="col-lg-8">
    @if ($total > 0)

    <div class="table-responsive">
        {{-- <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar"> --}}

            <table class="table table-hover table table-bordered table-bordered-bd-warning">
                <thead class="text-white" style="background: #ee761c">
                <tr>
                    <th class="table-th text-left text-white">DESCRIPCIÓN</th>
                    {{-- <th class="table-th text-center text-white">PRECIO</th> --}}
                    
                    <th class="table-th text-center text-white">PRECIO</th>

                    <th class="table-th text-center text-white">CANTIDAD</th>
                    <th class="table-th text-center text-white">IMPORTE</th>
                    {{-- <th class="table-th text-center text-white">DESC/REC</th> --}}
                    <th class="table-th text-center text-white">ACCIONES</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach ($cart as $item)
                    <tr>
                        {{-- Descripción Producto --}}
                        <td>
                            {{ $item->name }}
                        </td>
                        {{-- <td class="text-center">Bs{{ number_format($item->price, 2) }}</td> --}}
                        
                        {{-- Precio --}}
                        <td>
                            <div class="input-group"  style="min-width: 120px; max-width: 130px; align-items: center;">
                                <input type="number" style="max-height: 30px;"
                                id="pp{{$item->id}}" 
                                wire:change="precioventa({{$item->id}}, $('#pp' + {{$item->id}}).val(), $('#r' + {{$item->id}}).val() )"
                                value="{{ $item->price }}"
                                class="form-control" placeholder="Bs.." aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text">Bs</span>
                                </div>
                            </div>
                        </td>
                        {{-- Cantidad --}}
                        <td>
                            
                            <div class="input-group"  style="min-width: 120px; max-width: 130px; align-items: center;">
                                <input type="number" maxlength="{{$item->stock}}" max="{{$item->stock}}"
                                id="r{{$item->id}}" style="max-height: 30px;"
                                wire:change="UpdateQty({{$item->id}}, $('#r' + {{$item->id}}).val() )"
                                value="{{$item->quantity}}"
                                class="form-control" placeholder="Bs.." aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <span class="input-group-text">Uds.</span>
                                </div>
                            </div>
                        </td>
                        {{-- Importe --}}
                        <td class="text-center" style="max-width: 40px;">
                            {{-- <input type="text" class="form-control" value="{{ $item->price * $item->quantity, 2 }}"> --}}
                            
                            

                            <div class="input-group"  style="min-width: 120px; max-width: 130px; align-items: center;">
                                <input type="number" style="max-height: 30px;" id="c{{$item->id}}" 
                                wire:change="cambiarimporte({{$item->id}}, $('#c' + {{$item->id}}).val())"
                                value="{{ $item->price * $item->quantity, 2 }}"
                                class="form-control" placeholder="Importe..." aria-label="Recipient's username" aria-describedby="basic-addon2">
                                {{-- <div class="input-group-append">
                                    <button title="Ajustar Importe" wire:click="cambiarimporte()" class="btn btn-sm" style="background-color: rgb(0, 180, 235); color:white">
                                        <i class="fas fa-money-bill"></i>
                                    </button>
                                </div> --}}
                            </div>





                            






                            {{-- <h6>{{ $item->price * $item->quantity, 2 }}</h6> --}}
                        </td>


                        {{-- Acciones --}}
                        <td class="text-center">


                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button title="Eliminar Producto" onclick="Confirm('{{ $item->id }}','removeItem','¿Confirmas Eliminar el Registro?')" class="btn btn-sm" style="background-color: red; color:white">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <button title="Quitar una unidad" wire:click.prevent="decreaseQty({{ $item->id }})" class="btn btn-sm" style="background-color: rgb(99, 123, 142); color:white">
                                    <i class="fas fa-minus"></i>
                                </button>
    
                                <button title="Incrementar una unidad" wire:click.prevent="increaseQty({{ $item->id }})" class="btn btn-sm" style="background-color: rgb(10, 137, 235); color:white">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>


                            
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
            
        <h5 class="text-center text-muted">AGREGAR PRODUCTOS A LA VENTA</h5>

            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
        @endif
        <div wire:loading.inline wire:target="saveSale">
            <h4 class="text-danger text-center">Guardando venta...</h4>
        </div>
</div>