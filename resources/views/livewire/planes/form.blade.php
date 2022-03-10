@include('common.modalHead')
<div class='row' style="background: #f0ecec">

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Plataforma</label>
            <select wire:model.lazy="plataforma" class="form-control">
                <option value="Elegir" disabled selected>Elegir</option>

                @foreach ($platforms as $p)
                    <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                @endforeach
            </select>
            @error('plataforma')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>TIPO</label>
            <select wire:model.lazy="cuentaperfil" class="form-control">
                <option value="Elegir" disabled selected>Elegir</option>
                <option value="ENTERA">ENTERA</option>
                <option value="PERFIL">PERFIL</option>
            </select>
            @error('cuentaperfil')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>


    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Cantidad</label>
            <input type="number" wire:model.lazy="cantidaperf" class="form-control">
            @error('cantidaperf')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>


    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nombre Cliente</label>
            <input type="text" wire:model="nombre" class="form-control">
            @error('nombre')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Telefono Cliente</label>
            <input type="text" wire:model="celular" class="form-control">
            @error('celular')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Tipo de pago</label>
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

    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Meses para el plan</label>
            <input type="number" wire:model="meses" class="form-control" placeholder="PerfilNetflix1">
            @error('meses')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-4">
        <h6>Fecha de expiración del plan</h6>
        <div class="form-group">
            <input type="date" wire:model="expiration_plan" class="form-control">
            @error('expiration_plan')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-sm-12 col-md-12">
        <div class="form-group">
            <label>Observaciones</label>
            <input wire:model.lazy="observaciones" class="form-control" name="" rows="5">
            @error('observaciones')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>

</div>

@error('accounts')
    <span class="text-danger er">{{ $message }}</span>
@enderror
@error('profiles')
    <span class="text-danger er">{{ $message }}</span>
@enderror

<div class='row' style="background: #f0ecec">
    @if ($mostrartabla == 1)
        <div class="col-sm-12 col-md-12">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area row">
                    <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                        <table class="table table-hover table-sm" style="width:100%">
                            <thead class="text-white" style="background: #3B3F5C">
                                <tr>
                                    <th class="table-th text-withe text-center">Email</th>
                                    {{-- <th class="table-th text-withe">Contraseña Email</th> --}}
                                    <th class="table-th text-withe text-center">Contraseña Cuenta</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($accounts->count() == 0)
                                    <tr>
                                        <td colspan="2">
                                            <h6 class="text-center">No tienes cuentas enteras de esa plataforma</h6>
                                        </td>
                                    </tr>
                                @endif
                                @foreach ($accounts as $ap)
                                    <tr>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $ap->Correo->content }}</h6>
                                        </td>
                                        {{-- <td class="text-center">
                                            <h6 class="text-center">{{ $ap->Correo->pass }}</h6>
                                        </td> --}}
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $ap->password_account }}</h6>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($mostrartabla == 2)
        <div class="col-sm-12 col-md-12">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area row">
                    <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                        <table class="table table-hover table-sm" style="width:100%">
                            <thead class="text-white" style="background: #3B3F5C">
                                <tr>
                                    <th class="table-th text-withe text-center">Email</th>
                                    <th class="table-th text-withe">Contraseña Email</th>
                                    <th class="table-th text-withe">Contraseña Cuenta</th>
                                    <th class="table-th text-withe">Nombre Perfil</th>
                                    <th class="table-th text-withe">Pin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($profiles->count() == 0)
                                    <tr>
                                        <td colspan="5">
                                            <h6 class="text-center">No tienes perfiles de esa plataforma</h6>
                                        </td>
                                    </tr>
                                @endif
                                @foreach ($profiles as $ap)
                                    <tr>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $ap->email }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $ap->contraseña }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $ap->password_account }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $ap->nombre_perfil }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $ap->pin }}</h6>
                                        </td>
                                        {{-- <td class="text-center">
                                                        <a href="javascript:void(0)"
                                                            wire:click="Seleccionar({{ $d->cedula }},{{ $d->celular }})"
                                                            class="btn btn-dark mtmobile" title="Seleccionar">
                                                            <i class="fas fa-check"></i>
                                                        </a>
                                                    </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    @endif
</div>
@include('common.modalFooter')
