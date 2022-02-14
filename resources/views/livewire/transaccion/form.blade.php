@include('common.modalHead')
<div class='row' style="background: #f0ecec">
    <div class="col-sm-6 col-md-6" style="background: #f0ecec">

        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label>Origen Transacción</label>
                <select wire:model.lazy="origen" class="form-control">
                    <option value="Elegir" disabled selected>Elegir</option>

                    @foreach ($origenes as $orige)
                        <option value="{{ $orige->id }}">{{ $orige->nombre }}</option>
                    @endforeach
                </select>
                @error('origen') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label>Motivo</label>
                <select @if ($origen == 'Elegir') disabled @endif wire:model.lazy="motivo" class="form-control">
                    <option value="Elegir" disabled selected>Elegir</option>
                    @if ($origen != 'Elegir')
                        @foreach ($motivos as $mot)
                            <option value="{{ $mot->id }}">{{ $mot->nombre }}</option>
                        @endforeach
                    @endif
                </select>
                @error('motivo') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label>Monto</label>
                <input @if ($origen == 'Elegir' || $motivo == 'Elegir') disabled @endif type="text" wire:model.lazy="montoB"
                    class="form-control" placeholder="">
                @error('montoB') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="col-sm-8 col-md-12">
            <div class="form-group">
                <label>Monto a Registrar</label>
                <label class="form-control" wire:model.lazy="montoR" disabled>{{ $montoR }}</label>
                @error('montoR') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>
        
        @if ($origen != 'Elegir' && $motivo != 'Elegir' && $importe!=''&& $condicional==1)
            <div class="n-chk">
                <label class="new-control new-radio radio-classic-primary">
                    <input type="radio" class="new-control-input" name="custom-radio-2" id="SI" value="SI"
                    wire:model="comisionSiV">
                    <span class="new-control-indicator"></span>SI
                </label>
                <label class="new-control new-radio radio-classic-primary">
                    <input type="radio" class="new-control-input" name="custom-radio-2" id="NO" value="NO"
                    wire:model="comisionNoV">
                    <span class="new-control-indicator"></span>NO
                </label>
            </div>
        @endif

        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label>{{$montoCobrarPagar}}</label>
                <label class="form-control" wire:model="importe" disabled>{{ $importe }}</label>
                @error('importe') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>

        
    </div>
    <div class="col-sm-6 col-md-6" style="background: #f0ecec">
        @if ($mostrarCI == 1)
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label>CI</label>
                <input type="text" wire:model="cedula" class="form-control" placeholder="ej: 9407699">
                @error('cedula') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>
        @endif

        @if ($condicion != 0)
            <div class="vertical-scrollable">
                <div class="row layout-spacing">
                    <div class="col-md-12 ">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content widget-content-area row">
                                <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
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
                                                        <h6 class="text-center">{{ $d->cedula }}</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <h6 class="text-center">{{ $d->celular }}</h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="javascript:void(0)"
                                                            wire:click="Seleccionar({{ $d->cedula }},{{ $d->celular }})"
                                                            class="btn btn-dark mtmobile" title="Seleccionar">
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

        @if ($mostrartelf == 1)
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label>Teléfono Solicitante</label>
                <input type="text" wire:model.lazy="celular" class="form-control" placeholder="ej: 76797845">
                @error('celular') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>
        @endif

        @if ($mostrarTelfCodigo == 1)
            <div class="col-sm-12 col-md-12">
                <div class="form-group">
                    <label>Teléfono/Codigo Destino</label>
                    <input type="text" wire:model.lazy="codigo_transf" class="form-control"
                        placeholder="ej: 61718787">
                    @error('codigo_transf') <span class="text-danger er">{{ $message }}</span>@enderror
                </div>
            </div>
        @endif
        
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label>Observaciones</label>
                <textarea wire:model.lazy="observaciones" class="form-control" name="" rows="5"></textarea>
                @error('observaciones') <span class="text-danger er">{{ $message }}</span>@enderror
            </div>
        </div>

    </div>
</div>
@include('common.modalFooter')
