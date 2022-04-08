<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #414141">
                <h5 class="modal-title text-white">
                    <b>{{ $componentName }}</b> | {{ $selected_id > 0 ? 'EDITAR' : 'CREAR' }}
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">
                <div class='row'>
                    <div class="col-sm-6 col-md-6">

                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>
                                    <h6>Origen Transacción</h6>
                                </label>
                                <select wire:model.lazy="origen" class="form-control">
                                    <option value="Elegir" disabled selected>Elegir</option>

                                    @foreach ($origenes as $orige)
                                        <option value="{{ $orige->id }}">{{ $orige->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('origen')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>
                                    <h6>Motivo</h6>
                                </label>
                                <select @if ($origen == 'Elegir') disabled @endif wire:model.lazy="motivo"
                                    class="form-control">
                                    <option value="Elegir" disabled selected>Elegir</option>
                                    @if ($origen != 'Elegir')
                                        @foreach ($motivos as $mot)
                                            <option value="{{ $mot->id }}">{{ $mot->nombre }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('motivo')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>
                                    <h6>Monto</h6>
                                </label>
                                <input @if ($origen == 'Elegir' || $motivo == 'Elegir') disabled @endif type="number"
                                    wire:model.lazy="montoB" class="form-control" placeholder="">
                                @error('montoB')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-8 col-md-12">
                            <div class="form-group">
                                <h6>¿Con comisión?</h6>
                            </div>
                            <div class="n-chk">
                                <label class="new-control new-radio radio-classic-primary">
                                    <input @if ($MostrarRadioButton == 0) disabled @endif type="radio"
                                        class="new-control-input" name="custom-radio-2" id="SI" value="SI"
                                        wire:model="comisionSiV">
                                    <span class="new-control-indicator"></span>
                                    <h6>SI</h6>
                                </label>
                                <label class="new-control new-radio radio-classic-primary">
                                    <input @if ($MostrarRadioButton == 0) disabled @endif type="radio"
                                        class="new-control-input" name="custom-radio-2" id="NO" value="NO"
                                        wire:model="comisionNoV">
                                    <span class="new-control-indicator"></span>
                                    <h6>NO</h6>
                                </label>
                                @error('requerimientoComision')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-8 col-md-12">
                            <div class="form-group">
                                <label>
                                    <h6>Monto a Registrar</h6>
                                </label>
                                <label class="form-control" wire:model.lazy="montoR"
                                    disabled>{{ $montoR }}</label>
                                @error('montoR')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>
                                    <h6>{{ $montoCobrarPagar }}</h6>
                                </label>
                                <label class="form-control" wire:model="importe" disabled>{{ $importe }}</label>
                                @error('importe')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                    </div>

                    <div class="col-sm-6 col-md-6">


                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>
                                    <h6>Cedula de identidad</h6>
                                </label>
                                <input @if ($mostrarCI == 0) disabled @endif type="number"
                                    wire:model="cedula" class="form-control">
                                @error('cedula')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        @if ($BuscarCliente != 0)
                            <div class="vertical-scrollable">
                                <div class="row layout-spacing">
                                    <div class="col-md-12 ">
                                        <div class="statbox widget box box-shadow">
                                            <div class="widget-content widget-content-area row">
                                                <div
                                                    class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                                                    <table class="table table-hover table-sm" style="width:100%">
                                                        <thead class="text-white" style="background: #3B3F5C">
                                                            <tr>
                                                                <th class="table-th text-withe text-center">CEDULA</th>
                                                                <th class="table-th text-withe">Teléfono</th>
                                                                <th class="table-th text-withe">Acccion</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($datos as $d)
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <h6 class="text-center">{{ $d->cedula }}
                                                                        </h6>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <h6 class="text-center">{{ $d->celular }}
                                                                        </h6>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a href="javascript:void(0)"
                                                                            wire:click="Seleccionar({{ $d->cedula }},{{ $d->celular }})"
                                                                            class="btn btn-dark mtmobile"
                                                                            title="Seleccionar">
                                                                            <i class="fas fa-check"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif


                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>
                                    <h6>Teléfono Solicitante</h6>
                                </label>
                                <input @if ($mostrartelf == 0) disabled @endif type="number"
                                    wire:model="celular" class="form-control">
                                @error('celular')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        @if ($BuscarClientePorCel != 0)
                            <div class="vertical-scrollable">
                                <div class="row layout-spacing">
                                    <div class="col-md-12 ">
                                        <div class="statbox widget box box-shadow">
                                            <div class="widget-content widget-content-area row">
                                                <div
                                                    class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                                                    <table class="table table-hover table-sm" style="width:100%">
                                                        <thead class="text-white" style="background: #3B3F5C">
                                                            <tr>
                                                                <th class="table-th text-withe text-center">CEDULA</th>
                                                                <th class="table-th text-withe">Teléfono</th>
                                                                <th class="table-th text-withe">Acccion</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($datos2 as $d)
                                                                <tr>
                                                                    <td class="text-center">
                                                                        <h6 class="text-center">{{ $d->cedula }}
                                                                        </h6>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <h6 class="text-center">{{ $d->celular }}
                                                                        </h6>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a href="javascript:void(0)"
                                                                            wire:click="SeleccionarTelf({{ $d->celular }})"
                                                                            class="btn btn-dark mtmobile"
                                                                            title="Seleccionar">
                                                                            <i class="fas fa-check"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif


                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>
                                    <h6>Teléfono/Codigo Destino</h6>
                                </label>
                                <input @if ($mostrarTelfCodigo == 0) disabled @endif type="number"
                                    wire:model.lazy="codigo_transf" class="form-control">
                                @error('codigo_transf')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>
                                    <h6>Observaciones</h6>
                                </label>
                                <textarea wire:model.lazy="observaciones" class="form-control" name="" rows="5"></textarea>
                                @error('observaciones')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="CargarAnterior()"
                    class="btn btn-dark close-btn text-info">CARGAR
                    ANTERIOR</button>
                <button type="button" wire:click.prevent="resetUI()"
                    class="btn btn-dark close-btn text-info">LIMPIAR</button>
                <button type="button" wire:click.prevent="Store()"
                    class="btn btn-dark close-btn text-info">GUARDAR</button>
            </div>
        </div>
    </div>
</div>
