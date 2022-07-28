<div wire:ignore.self class="modal fade" id="entregarservicio" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">
                    Entregar Servicio - Orden de Servicio N°:{{$this->id_orden_de_servicio}}
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">

                <div class="text-center">
                    <label>
                        <h5><b>{{strtoupper($this->nombrecliente)}}</b> - {{$this->celularcliente}}</h5>
                    </label>
                </div>
                @if(@Auth::user()->hasPermissionTo('Asignar_Tecnico_Servicio'))
                <div class="form-row">
                    <div class="form-row text-center" style="width: 33.33%; margin-right: 7px;">
                        <div class="col-md-12">
                            <label for="validationTooltip01">Precio del Servicio Bs</label>
                            <input type="number" wire:model.lazy="edit_precioservicio" class="form-control">
                        </div>
                        @error('edit_precioservicio')
                                <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-row text-center" style="width: 33.33%; margin-right: 7px;">
                        <div class="col-md-12">
                            <label for="validationTooltip01">A Cuenta Bs</label>
                            <input type="number" wire:model="edit_acuenta" class="form-control">
                        </div>
                    </div>
                    <div class="form-row text-center" style="width: 33.33%">
                        <div class="col-md-12">
                            <label>Monto a Cobrar Bs</label>
                            <div class="text-center">
                                <label for="validationTooltipUsername"> <h2>{{number_format($this->edit_saldo,2)}}</h2> </label>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="form-row">
                    <div class="form-row text-center" style="width: 33.33%; margin-right: 7px;">
                        <div class="col-md-12">
                            <label for="validationTooltip01">Precio del Servicio Bs</label>
                            <div class="text-center">
                                <label for="validationTooltipUsername"> <h2>{{number_format($this->precioservicio,2)}}</h2> </label>
                            </div>
                        </div>
                        @error('edit_precioservicio')
                                <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-row text-center" style="width: 33.33%; margin-right: 7px;">
                        <div class="col-md-12">
                            <label for="validationTooltip01">A Cuenta Bs</label>
                            <div class="text-center">
                                <label for="validationTooltipUsername"> <h2>{{number_format($this->acuenta,2)}}</h2> </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row text-center" style="width: 33.33%">
                        <div class="col-md-12">
                            <label>Monto a Cobrar Bs</label>
                            <div class="text-center">
                                <label for="validationTooltipUsername"> <h2>{{number_format($this->edit_saldo,2)}}</h2> </label>
                            </div>
                        </div>
                    </div>
                </div>
                @endif





                @if($this->estadocaja == "abierto")
                <div class="row">
                    <div class="col-sm-6 col-md-3">

                    </div>
                    <div class="col-sm-6 col-md-6">
                            <div class="form-group text-center">
                                <strong>Tipo de Pago</strong>
            
                                <select wire:model="tipopago" class="form-control">
                                    <option disabled value="Elegir">Elegir</option>
                                    @foreach ($listacarteras as $cartera)
                                    <option value="{{$cartera->idcartera}}">{{ucwords(strtolower($cartera->nombrecartera)) .' - ' .ucwords(strtolower($cartera->dc))}}</option>
                                    @endforeach
                                    @foreach ($listacarterasg as $carteras)
                                    <option value="{{$carteras->idcartera}}">{{ucwords(strtolower($carteras->nombrecartera)) .' - ' .ucwords(strtolower($carteras->dc))}}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                    </div>
                    
                    <div class="col-sm-6 col-md-3">

                    </div>
                </div>
                @else

                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h2>No tiene ninguna caja abierta</h2>
                    </div>
                </div>

                @endif







                





















            </div>

            <div class="modal-footer">
                
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                @if($this->estadocaja == "abierto")
                <button type="button" class="btn btn text-white" wire:click="entregarservicio()" style="background-color: rgb(22, 192, 0)">Registrar Como Entregado</button>
                @endif

            </div>
        </div>
    </div>
</div>