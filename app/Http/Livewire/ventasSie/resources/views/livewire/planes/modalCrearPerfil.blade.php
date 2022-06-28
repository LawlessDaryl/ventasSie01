<div wire:ignore.self id="Modal_crear_perfil" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Cree el Perfil y selecciona en cual cuenta crearla</b>
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Cantidad a crear</h6>
                            </label>
                            <input wire:model.lazy="CantidadPerfilesCrear" class="form-control">
                            @error('nombrePerfil')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <table class="table table-hover table-sm" style="width:100%">
                            <thead class="text-white" style="background: #3B3F5C">
                                <tr>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">Plataforma</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">Cuenta</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">Expiración</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">Max.Perf</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">Perf.Activ</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">Espacios</th>
                                    <th class="table-th text-withe text-center" style="font-size: 80%">Seleccionar
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->cuentasEnteras as $c)
                                    @if ($c->number_profiles != $c->perfActivos)
                                        <tr>
                                            <td class="text-center">
                                                <h6 class="text-center">{{ $c->nombre }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6 class="text-center">{{ $c->content }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6 class="text-center">
                                                    {{ \Carbon\Carbon::parse($c->expiration_account)->format('d/m/Y') }}
                                            </td>
                                            <td class="text-center">
                                                <h6 class="text-center">{{ $c->number_profiles }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6 class="text-center">{{ $c->perfActivos }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <h6 class="text-center">{{ $c->cantiadadQueSePuedeCrear }}</h6>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" class="btn btn-warning"
                                                    wire:click.prevent="SeleccionarCuenta({{ $c->id }})">Crear
                                                    aqui</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
