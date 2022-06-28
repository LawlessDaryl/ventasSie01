<div wire:ignore.self id="modal-details" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>{{ $origenNombre }} | {{ $motivoNombre }}</b>
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>PREGUNTAR</label>
                            <div class="row">
                                <div class="col-sm-12 col-md-3">
                                    <div class="form-group">
                                        <div class="n-chk">
                                            <label class="new-control new-radio radio-classic-primary">
                                                <input type="radio" class="new-control-input" name="custom-radio-4"
                                                    id="SI" value="si" wire:model="preguntar" checked>
                                                <span class="new-control-indicator"></span>SI
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="form-group">
                                        <div class="n-chk">
                                            <label class="new-control new-radio radio-classic-primary">
                                                <input type="radio" class="new-control-input" name="custom-radio-4"
                                                    id="NO" value="nopreguntar" wire:model="preguntar">
                                                <span class="new-control-indicator"></span>NO
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            @if ($preguntar == 'si')
                                <label>SI</label>
                            @else
                                <label>¿COMO ES O SON AFECTADOS LOS VALORES?</label>
                            @endif
                            <div class="row">
                                <div class="col-sm-12 col-md-3">
                                    <div class="form-group">

                                        <div class="n-chk">
                                            <label class="new-control new-radio radio-classic-primary">
                                                <input type="radio" class="new-control-input" name="custom-radio-2"
                                                    id="SI" value="suma" wire:model="suma_resta_si">
                                                <span class="new-control-indicator"></span>SUMA
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="form-group">

                                        <div class="n-chk">
                                            <label class="new-control new-radio radio-classic-primary">
                                                <input type="radio" class="new-control-input" name="custom-radio-2"
                                                    id="NO" value="resta" wire:model="suma_resta_si">
                                                <span class="new-control-indicator"></span>RESTA
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <div class="form-group">

                                        <div class="n-chk">
                                            <label class="new-control new-radio radio-classic-primary">
                                                <input type="radio" class="new-control-input" name="custom-radio-2"
                                                    id="NO" value="mantiene" wire:model="suma_resta_si">
                                                <span class="new-control-indicator"></span>MANTIENE
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('suma_resta_si')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    @if ($preguntar == 'si')
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>NO</label>
                                <div class="row">
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-group">

                                            <div class="n-chk">
                                                <label class="new-control new-radio radio-classic-primary">
                                                    <input type="radio" class="new-control-input" name="custom-radio-3"
                                                        id="SI" value="suma" wire:model="suma_resta_no">
                                                    <span class="new-control-indicator"></span>SUMA
                                                </label>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-group">

                                            <div class="n-chk">
                                                <label class="new-control new-radio radio-classic-primary">
                                                    <input type="radio" class="new-control-input" name="custom-radio-3"
                                                        id="NO" value="resta" wire:model="suma_resta_no">
                                                    <span class="new-control-indicator"></span>RESTA
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-group">

                                            <div class="n-chk">
                                                <label class="new-control new-radio radio-classic-primary">
                                                    <input type="radio" class="new-control-input" name="custom-radio-3"
                                                        id="NO" value="mantiene" wire:model="suma_resta_no">
                                                    <span class="new-control-indicator"></span>MANTIENE
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @error('suma_resta_no')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Afectado</label>
                            <select wire:model.lazy="afectadoSi" class="form-control">
                                <option value="Elegir" selected>Elegir</option>
                                <option value="montoR">Monto a Registrar</option>
                                <option value="montoC">Monto a Cobrar</option>
                                <option value="ambos">Ambos</option>
                            </select>
                            @error('afectadoSi')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    @if ($preguntar == 'si')
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>Afectado</label>
                                <select wire:model.lazy="afectadoNo" class="form-control">
                                    <option value="Elegir" selected>Elegir</option>
                                    <option value="montoR">Monto a Registrar</option>
                                    <option value="montoC">Monto a Cobrar</option>
                                    <option value="ambos">Ambos</option>
                                </select>
                                @error('afectadoNo')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>¿CI DE CLIENTE?</label>
                            <select wire:model.lazy="CIdeCliente" class="form-control">
                                <option value="Elegir" selected>Elegir</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                            @error('CIdeCliente')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>¿Teléfono Solicitante?</label>
                            <select wire:model.lazy="telefSolicitante" class="form-control">
                                <option value="Elegir" selected>Elegir</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                            @error('telefSolicitante')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>¿Teléfono Destino / Código?</label>
                            <select wire:model.lazy="telefDestino_codigo" class="form-control">
                                <option value="Elegir" selected>Elegir</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                            @error('telefDestino_codigo')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click.prevent="Asignar()" class="btn btn-warning close-btn text-info"
                            style="background: #3b3f5c">Terminar</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
