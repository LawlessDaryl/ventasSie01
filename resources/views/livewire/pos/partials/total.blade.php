
<div class="row">
               
    <div class="connect-sorting">
        <div class="connect-sorting-content">
            <div class="card simple-title-task ui-sortable-handle">
                <div class="card-body">
                    <div class="row">
                                
                        <div class="col-md-3">
                            <label style="color: black">
                            Cliente Anónimo:
                            </label>
                        </div>
                        <div class="col-md-3 align-items-center">
                            <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                                {{-- <input type="checkbox" wire:model.lazy="clienteanonimo" checked> --}}
                                <input type="checkbox" wire:click="clienteanonimo()" checked wire:model="clienteanonimo">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        
                        <div class="col-md-2">
                            <label style="color: black">
                            Factura:
                            </label>
                        </div>
                        <div class="col-md-2">
                            <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                                <input type="checkbox">
                                <span class="slider round"></span>
                            </label>
                        </div>

                    </div>
                </div>
                
                <div class="col-sm-12 col-md-8">
                    <div class="form-group">
                        <label style="color: black">Tipo de Pago:</label>
                        <select wire:model="tipopago" class="form-control">
                            <option value="EFECTIVO" selected>EFECTIVO</option>
                            <option value="Banco">CUENTA BANCARIA</option>
                            <option value="TigoStreaming">TIGO MONEY</option>
                        </select>
                        @error('tipopago')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="text-center">
                        <label style="color: black">
                            <h4>TOTAL: Bs {{ number_format($total, 2) }} </h4>
                            <input type="hidden" id="hiddenTotal" value="{{ $total }}">
                            <h6 class="mt-3">Artículos:{{$itemsQuantity}}</h6>
                        </label>
                    </div>
            </div>
        </div>
    </div>

</div>




<!-- <div class="row">



                            <label style="color: black">Cliente Anónimo:</label>
                            <label class="switch s-outline s-outline-primary  mb-4 mr-2">
                                <input type="checkbox" checked="">
                                <span class="slider round"></span>
                            </label>


    <div class="col-sm-12">
        <div>
            <div class="connect-sorting">
                <h5 class="text-center mb-3">RESUMEN DE VENTA</h5>
                <div class="connect-sorting-content">
                    <div class="card simple-title-task ui-sortable-handle">
                        <div class="card-body">
                            <div class="task-header">
                                <div>
                                    <h2>TOTAL: ${{ number_format($total, 2) }} </h2>
                                    <input type="hidden" id="hiddenTotal" value="{{ $total }}">
                                </div>
                            </div>
                            <h4 class="mt-3">Artículos:{{$itemsQuantity}}</h4>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div> -->
