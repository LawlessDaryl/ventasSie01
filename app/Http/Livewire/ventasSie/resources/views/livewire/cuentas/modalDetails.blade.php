<div wire:ignore.self id="modal-details" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>CREACION DE PERFILES</b>
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                {{-- @if ($mostrarCampos == 0)
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label><h6>Nombre Perfil</h6></label>
                                <input type="text" wire:model.lazy="nameP" class="form-control"
                                    placeholder="ej: PerfilNetflix1">
                                @error('nameP')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label><h6>PIN</h6></label>
                                <input type="text" wire:model.lazy="PIN" class="form-control" placeholder="ej: 0110">
                                @error('PIN')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label><h6>Estado</h6></label>
                                <select wire:model='estado' class="form-control">
                                    <option value="ACTIVO">ACTIVO</option>
                                    <option value="INACTIVO">INACTIVO</option>
                                </select>
                                @error('estado')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label><h6>Disponibilidad</h6></label>
                                <select wire:model='availability' class="form-control">
                                    <option value="LIBRE">LIBRE</option>
                                    <option value="OCUPADO">OCUPADO</option>
                                </select>
                                @error('availability')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label><h6>Observaciones</h6></label>
                                <input type="text" wire:model.lazy="Observaciones" class="form-control"
                                    placeholder="Perfil para ...">
                                @error('Observaciones')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group text-center mt-4">
                                <a href="javascript:void(0)" class="btn btn-warning"
                                    wire:click.prevent="CrearPerfil()">Crear Perfil</a>
                            </div>
                        </div>

                    </div>
                @else
                    <div>
                        <h5 class="modal-title">
                            <b class="text-center">Esta cuenta ya tiene todos los perfiles creados</b>
                        </h5>
                    </div>
                @endif --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mt-1">
                        <thead class="text-white" style="background: #3b3ff5;">
                            <tr>
                                <th class="table-th text-center text-white">NOMBRE PERFIL</th>
                                <th class="table-th text-center text-white">PIN</th>
                                <th class="table-th text-center text-white">STATUS</th>
                                <th class="table-th text-center text-white">DISPONIBILIDAD</th>
                                <th class="table-th text-center text-white">OBSERVACIONES</th>
                                {{-- <th class="table-th text-center text-white">BORRAR</th> --}}
                            </tr>
                        </thead>

                        <tbody>                            
                            @foreach ($perfiles as $d)
                                <tr>
                                    <td class="text-center">
                                        <h6>{{ $d->namep }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $d->PIN }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $d->estado }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $d->availability }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $d->Observaciones }}</h6>
                                    </td>
                                    <td class="text-center">
                                        {{-- <a href="javascript:void(0)"
                                            onclick="Confirmar('{{ $d->id }}','{{ $d->namep }}')"
                                            class="btn btn-warning" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a> --}}
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
