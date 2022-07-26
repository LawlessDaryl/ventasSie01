<div wire:ignore.self id="modal-detailsr" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Recaudos y Diferencia de Efectivo</b>
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row pt-1 pb-1 mb-3" style="background-color: rgb(191, 235, 220)">

                    <div class="col-sm-4 col-md-6 col-lg-3">
                        
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

               

                    <div class="col-sm-4 col-md-3 col-lg-3">
                        
                            <h6>Monto a recaudar</h6>
                            <input type="number" wire:model="cantidad" class="form-control">
                            @error('cantidad')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-3">
                        
                        <div>RECAUDO</div>
                        <br>
                      <h6>{{number_format($recaudo,2)}}</h6>
                      
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <br>
                    </div>

                </div>
                <div class="row pt-1 pb-1" style="background-color: rgb(224, 247, 162)">

                    <div class="col-sm-4 col-md-6 col-lg-3">
                        <div class="form-group">

                            <h6>Cartera</h6>
                            <select wire:model='cartera_id2' class="form-control">
                                <option value=null selected>Elegir</option>
                                @foreach ($carterasSucursal as $item)
                                @if($item->tipo=="CajaFisica")
                                    <option value="{{ $item->cid }}">{{ $item->cajaNombre }},
                                        {{ $item->carteraNombre }}
                                    </option>
                                @endif
                                
                                @endforeach
                            </select>
                            @error('cartera_id2')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    
                </div>
                    <div class="col-sm-12 col-md-6 col-lg-2">
                        <div class="form-group">
                            <h6>Sobrante/Faltante</h6>
                            <select wire:model='diferenciaCaja' class="form-control">
                                <option value=null selected>Elegir</option>
                                <option value="SOBRANTE" selected>Sobrante</option>
                                <option value="FALTANTE" selected>Faltante</option>
                             
                            </select>
                            @error('diferenciaCaja')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

            
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <div class="form-group">
                            <h6>Monto Diferencia</h6>
                            <input type="number" wire:model="montoDiferencia" class="form-control">
                            @error('montoDiferencia')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-4">
                        <div class="form-group">
                            <h6>Añadir una Observacion:</h6>
                            <input type="text" wire:model="obsDiferencia" class="form-control">
                            @error('obsDiferencia')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                </div>
                
                <div class="col-sm-12 col-md-3 col-lg-12 mt-3">
                    <div class="row d-flex justify-content-center">

                        <a href="javascript:void(0)" class="btn btn-warning" wire:click.prevent="GenerarR()"> <i class="fas fa-check"></i> Generar</a>
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
