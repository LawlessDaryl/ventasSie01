<div wire:ignore.self id="modal-detailsr" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>GENERAR RECAUDOs</b>
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <h6>Cartera</h6>
                            <select wire:model='cartera_id' class="form-control">
                                <option value=null selected>Elegir</option>
                                @foreach ($carterasSucursal as $item)
                                @if($item->tipo=="CajaFisica")
                                    <option value="{{ $item->cid }}">{{ $item->cajaNombre }},
                                        {{ $item->carteraNombre }}
                                    </option>
                                @endif
                                
                                @endforeach
                            </select>
                            @error('cartera_id')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

               

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <h6>Monto a recaudar</h6>
                            <input type="number" wire:model="cantidad" class="form-control">
                            @error('cantidad')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                        <div>RECAUDO</div>
                        <br>
                      <h6 for="">{{$recaudo}}</h6>
                      </div>
                    </div>



               

                </div>
                <div>
                    <a href="javascript:void(0)" class="btn btn-warning" wire:click.prevent="GenerarR()">Generar</a>
                </div>

            </div>


        </div>
    </div>
</div>
