<div wire:ignore.self class="modal fade" id="modificartransaccion" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #414141">
                <h5 class="modal-title text-white">
                    EDITAR TRANSACCION
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
                                    <h6>Origen transacción</h6>
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
                                <select wire:model.lazy="motivo"
                                    class="form-control">
                                    <option value="Elegir" disabled selected>Elegir</option>

                                    @foreach ($motivos as $mot)
                                        <option value="{{ $mot->id }}">{{ $mot->nombre }}</option>
                                    @endforeach

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
                                <input @if ($motivo == 'Elegir') disabled @endif type="number"
                                    wire:model="montoB" class="form-control" placeholder="">
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
                                <label class="new-control new-radio radio-classic-primary ">
                                    <input @if ($MostrarRadioButton == 0) disabled @endif type="radio" {{$a}}
                                        class="new-control-input" name="custom-radio-2" id="{{ $identificador }}"
                                        value="SI" wire:click="ComisionSi()">
                                    <span class="new-control-indicator"></span>
                                    <h6>SI</h6>
                                </label>
                                <label class="new-control new-radio radio-classic-primary">
                                    <input @if ($MostrarRadioButton == 0) disabled @endif type="radio" {{$b}}
                                        class="new-control-input" name="custom-radio-2" id="{{ $identificador2 }}"
                                        value="NO" wire:click="ComisionNo()">
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
                                    <h6>Monto a registrar</h6>
                                </label>
                                <h6 class="form-control" wire:model.lazy="montoR">
                                    <strong>{{ $montoR }}</strong>
                                </h6>

                            </div>
                        </div>


                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>
                                    <h6>{{ $montoCobrarPagar }}</h6>
                                </label>
                                <h6 class="form-control" wire:model="importe"><strong>{{ $importe }}</strong>
                                </h6>

                            </div>
                        </div>


                    </div>

                    <div class="col-sm-6 col-md-6">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>
                                    <h6>Cédula de identidad</h6>
                                </label>
                                <input @if ($mostrarCI == 0) disabled @endif type="number"
                                    wire:model="cedula" class="form-control" wire:click="cambiarafalse1()">
                                @error('cedula')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        @if($mostrarunavez1 == false)
                            @if (count($datosPorCedula) > 0)
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
                                                                    <th class="table-th text-withe text-center">Cédula</th>
                                                                    <th class="table-th text-withe text-center">Teléfono
                                                                    </th>
                                                                    <th class="table-th text-withe text-center">Acccion</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($datosPorCedula as $d)
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
                                                                                class="btn btn-warning mtmobile"
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
                        @endif


                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label>
                                    <h6>Teléfono solicitante</h6>
                                </label>
                                <input @if ($mostrartelf == 0) disabled @endif type="number"
                                    wire:model="celular" class="form-control" wire:click="cambiarafalse2()">
                                @error('celular')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @if($mostrarunavez2 == false)
                            @if (count($datosPorTelefono) > 0)
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
                                                                    <th class="table-th text-withe text-center">Teléfono
                                                                    </th>
                                                                    <th class="table-th text-withe text-center">Acccion</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($datosPorTelefono as $d)
                                                                    <tr>
                                                                        <td class="text-center">
                                                                            <h6 class="text-center">{{ $d->celular }}
                                                                            </h6>
                                                                        </td>
                                                                        <td class="text-center">
                                                                            <a href="javascript:void(0)"
                                                                                wire:click="SeleccionarTelf({{ $d->celular }})"
                                                                                class="btn btn-warning mtmobile"
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
                                    <h6>Observaciones (opcional)</h6>
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
                    class="btn btn-warning close-btn text-info">CARGAR
                    ANTERIOR</button>
                <button type="button" wire:click.prevent="resetUI()"
                    class="btn btn-warning close-btn text-info">LIMPIAR</button>
                <button type="button" wire:click.prevent="Store()"
                    class="btn btn-warning close-btn text-info">GUARDAR</button>
            </div>
        </div>
    </div>
</div>