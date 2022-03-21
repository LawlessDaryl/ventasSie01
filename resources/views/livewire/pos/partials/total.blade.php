<div class="connect-sorting">
        <div class="connect-sorting-content">
            <div class="card simple-title-task ui-sortable-handle">
                <div class="card-body">
                    <!--
                    <div class="row">

                        
                        <div class="col-md-2">
                            <input class="form-control" wire:model="nombreproducto"  type="text" placeholder="Buscar Productos">
                        </div>
                                
                        <div class="col-md-2">
                            <label style="color: black">
                            Cliente Anónimo:
                            </label>
                        </div>
                        <div class="col-md-1 align-items-center">
                            <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                                {{-- <input type="checkbox" wire:model.lazy="clienteanonimo" checked> --}}
                                <input type="checkbox" wire:click="clienteanonimo()" checked wire:model="clienteanonimo">
                                <span class="slider round"></span>
                            </label>
                        </div>
                        
                        <div class="col-md-1">
                            <label style="color: black">
                            Factura:
                            </label>
                        </div>
                        <div class="col-md-1">
                            <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                                <input type="checkbox" wire:model="factura">
                                <span class="slider round"></span>
                            </label>
                        </div>

                        

                        <div class="col-md-2">


                            <select wire:model="tipopago" class="form-control">
                                <option value="EFECTIVO" selected>EFECTIVO</option>
                                <option value="Banco">CUENTA BANCARIA</option>
                                <option value="TigoStreaming">TIGO MONEY</option>
                            </select>
                            @error('tipopago')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="col-md-3">
                            <label style="color: black">
                                <h4>TOTAL: Bs {{ number_format($total, 2) }} </h4>
                                <input type="hidden" id="hiddenTotal" value="{{ $total }}">
                                <h6 class="mt-3">Artículos:{{$itemsQuantity}}</h6>
                            </label>
                            
                        </div>

                    </div>
                    -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="text-center">
                                        <div class="form-group">
                                            <label>Buscar Productos:</label>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <input class="form-control" wire:model="nombreproducto"  type="text" placeholder="Buscar...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Cliente Anònimo</label>

                                        <div class="row">

                                            <div class="col-md-6 mb-4 text-center">
                                                <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                                                    {{-- <input type="checkbox" wire:model.lazy="clienteanonimo" checked> --}}
                                                    <input type="checkbox" wire:click="clienteanonimo()" checked wire:model="clienteanonimo">
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-2">
                                    <div class="text-center">
                                        <div class="form-group">
                                            <label>Factura:</label>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                                                        <input type="checkbox" wire:model="factura">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-2">
                                    <div class="text-center">
                                        <div class="form-group">
                                            <label>Tipo de Pago:</label>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <select wire:model="tipopago" class="form-control input-sm" id="end-in2">
                                                            <option value="EFECTIVO">EFECTIVO</option>
                                                            <option value="Banco">CUENTA BANCARIA</option>
                                                            <option value="TigoStreaming">TIGO MONEY</option>
                                                        </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="text-center">
                                        <div class="form-group">
                                            <label>Total Artìculos:</label>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label style="color: black">
                                                        <h6 class="mt-3">Artículos:{{$itemsQuantity}}</h6>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    
                                    <div class="form-group">
                                        <label>TOTAL VENTA:</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label style="color: black">
                                                    <h4> Bs {{ number_format($total, 2) }} </h4>
                                                    <input type="hidden" id="hiddenTotal" value="{{ $total }}">
                                                </label>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
