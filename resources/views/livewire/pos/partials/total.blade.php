<div class="row">


    <div class="col-lg-12">
        <div class="jumbotron-fluid">

                <blockquote style="border-left: 2px solid #EE761C !important; " class="blockquote media-object">
                    <div class="row">

                       


                        
                            <div class="col-12 col-md-3 col-lg-2">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <strong>Cliente Anònimo</strong>
                                            <br>
                                            <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                                                {{-- <input type="checkbox" wire:model.lazy="clienteanonimo" checked> --}}
                                                <input type="checkbox" wire:click="clienteanonimo()" checked wire:model="clienteanonimo">
                                                <span class="slider round"></span>
                                            </label>
                                            
                                    
                                    </div>
                                </div>
                            </div>

                        
                            <div class="col-12 col-md-3 col-lg-2">

                                <div class="col-lg-12">
                                    <strong>Factura</strong>
                                    <br>
                                        <label class="switch s-icons s-outline  s-outline-primary  mb-4 mr-2">
                                            <input type="checkbox" wire:model="factura">
                                            <span class="slider round"></span>
                                        </label>
                                </div>
    
                            </div>
                        
                            <div class="col-12 col-md-3 col-lg-2">


                                <div class="col-lg-12">
                                    <div class="form-group">
                                    <strong>Tipo de Pago</strong>
                                    <select wire:model="tipopago" class="form-control">
                                        <option value="EFECTIVO" selected>EFECTIVO</option>
                                        <option value="Banco">CUENTA BANCARIA</option>
                                        <option value="TigoStreaming">TIGO MONEY</option>
                                    </select>
                                    </div>
                                </div>

                            </div>
                        
                            <div class="col-12 col-md-3 col-lg-2">


                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <strong>Total Artìculos:</strong>
                                        <br>
                                        <h6>{{$itemsQuantity}}</h6>
                                    </div>
                                </div>

                            </div>

                            <div class="col-12 col-md-3 col-lg-2">


                                <div class="col-lg-12">
                                        <div class="form-group">
                                            <strong>TOTAL VENTA:</strong>
                                            <br>
                                            <label style="color: black">
                                                <h4> Bs {{ number_format($total, 2) }} </h4>
                                                <input type="hidden" id="hiddenTotal" value="{{ $total }}">
                                            </label>
                                        </div>
                                    </div>

                            </div>

                            <div class="col-12 col-md-3 col-lg-2">


                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <strong>Observacion: </strong>
                                        <textarea  class="form-control" aria-label="With textarea"></textarea>
                                    </div>
                                </div>

                            </div>


                        
                </div>
            </blockquote>
    </div>
</div>
            

   




            






</div>