<div class="row">


    <div class="col-12 col-md-12">
        <div class="jumbotron-fluid">

                <blockquote style="border-left: 2px solid #EE761C !important;" class="blockquote media-object">
                    <div class="row">
                        
                            <div class="col-12 col-md-3 col-lg-2">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <strong>Cliente Anònimo</strong>
                                            <br>
                                            <label class="colorinput">
                                                <input type="checkbox" wire:click="clienteanonimo()" checked wire:model="clienteanonimo" class="colorinput-input">
                                                <span class="colorinput-color bg-warning"></span>
                                            </label>
                                    
                                    </div>
                                </div>
                            </div>

                        
                            <div class="col-12 col-md-3 col-lg-2">

                                <div class="col-lg-12">
                                    <strong>Venta con Factura</strong>
                                    <br>
                                        <label class="colorinput">
                                            <input id="factura" type="checkbox" wire:model="factura" class="colorinput-input">
                                            <span class="colorinput-color bg-warning"></span>
                                        </label>
                                </div>
    
                            </div>
                        
                            <div class="col-12 col-md-3 col-lg-2">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                    <strong>Tipo de Pago</strong>
                                    <select wire:model="tipopago" class="form-control">
                                        <option disabled value="Elegir">Elegir</option>
                                        @foreach ($listacarteras as $cartera)
                                        <option value="{{$cartera->idcartera}}">{{ucwords(strtolower($cartera->nombrecartera)) .' - ' .ucwords(strtolower($cartera->dc))}}</option>
                                        @endforeach
                                    </select>
                                    </div>

                                </div>

                            </div>
                        
                            <div class="col-12 col-md-3 col-lg-2">


                                <div class="col-lg-12 text-center">
                                   
                                    <div class="form-group">
                                        <strong>Total Artìculos:</strong>
                                        <br>
                                        <h3>{{$itemsQuantity}}</h3>
                                    </div>
                                </div>

                            </div>

                            {{-- <div class="col-12 col-md-3 col-lg-2">
                                <div class="col-lg-12">
                                        <strong>Descuentos/Recargos:</strong>
                                        <div class="input-group mb-4">
                                            <input type="number" value="0" class="form-control" aria-label="Text input with segmented dropdown button">
                                            <div class="input-group-prepend">
                                                <select class="btn btn-outline-info dropdown-toggle dropdown-toggle-split">
                                                    <option value="Bs" selected>Bs</option>
                                                    <option value="%">%</option>
                                                </select>
                                            </div>
                                          </div>
                                </div>
    
                            </div> --}}

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
                                        <textarea class="form-control" aria-label="With textarea" wire:model="observacion"></textarea>
                                    </div>
                                </div>

                            </div>


                        
                </div>
            </blockquote>
    </div>
</div>
            

   




            






</div>