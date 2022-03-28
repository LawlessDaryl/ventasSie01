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
                                <h6>Nombre Perfil</h6>
                            </label>
                            <input wire:model.lazy="nombrePerfil" class="form-control">
                            @error('nombrePerfil')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>PIN</h6>
                            </label>
                            <input wire:model.lazy="pinPerfil" class="form-control">
                            @error('pinPerfil')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <table class="table table-hover table-sm" style="width:100%">
                            <thead class="text-white" style="background: #3B3F5C">
                                <tr>
                                    <th class="table-th text-withe text-center">Cuenta</th>
                                    <th class="table-th text-withe text-center">Expiración</th>
                                    <th class="table-th text-withe text-center">Seleccionar
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($this->cuentasEnteras as $c)
                                    <tr>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $c->Correo->content }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $c->expiration_account }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" class="btn btn-dark"
                                                wire:click.prevent="SeleccionarCuenta({{ $c->id }})">Crear aqui</a>
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
