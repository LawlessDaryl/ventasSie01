<div wire:ignore.self id="Modal_combos" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>VENTA DE PERFILES POR COMBO</b>
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>
                                <h6>PLATAFORMA 1</h6>
                            </label>
                            <select wire:model.lazy="plataforma1" class="form-control">
                                <option value="Elegir" disabled selected>Elegir</option>
                                @foreach ($platforms1 as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                            @error('cuentaperfil')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>
                                <h6>PLATAFORMA 2</h6>
                            </label>
                            <select wire:model.lazy="plataforma2" class="form-control">
                                <option value="Elegir" disabled selected>Elegir</option>
                                @foreach ($platforms2 as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                            @error('cuentaperfil')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>
                                <h6>PLATAFORMA 3</h6>
                            </label>
                            <select wire:model.lazy="plataforma3" class="form-control">
                                <option value="Elegir" disabled selected>Elegir</option>
                                @foreach ($platforms3 as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                            @error('cuentaperfil')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>
                                <h6>CUENTAS PLATAFORMA 1</h6>
                            </label>
                        </div>
                    </div>
                    @if ($plataforma1 != 'Elegir')
                        <div class="col-sm-12 col-md-12">
                            <div class="statbox widget box box-shadow">
                                <div class="widget-content widget-content-area row">
                                    <div class="table-responsive table-wrapper-scroll-y my-custom-scrollbar">
                                        <table class="table table-hover table-sm" style="width:100%">
                                            <thead class="text-white" style="background: #3B3F5C">
                                                <tr>
                                                    <th class="table-th text-withe text-center">Email o Nombre Usuario
                                                    </th>
                                                    <th class="table-th text-withe text-center">Vencimiento</th>
                                                    <th class="table-th text-withe text-center">Espacios</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($cuentasp1->count() == 0)
                                                    <tr>
                                                        <td colspan="2">
                                                            <h6 class="text-center">No tiene cuentas con espacios
                                                            </h6>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @foreach ($cuentasp1 as $ap)
                                                    <tr>
                                                        <td class="text-center">
                                                            <h6 class="text-center">{{ $ap->account_name }}
                                                            </h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center">{{ $ap->expiration_account }}
                                                            </h6>
                                                        </td>
                                                        <td class="text-center">
                                                            <h6 class="text-center">{{ $ap->price }}</h6>
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

                </div>
            </div>
        </div>
    </div>
</div>
