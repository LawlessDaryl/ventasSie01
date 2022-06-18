<div wire:ignore.self id="Modal_Observaciones" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Informacion sobre el plan</b>
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
                                <h6>Nombre Cliente</h6>
                            </label>
                            <input type="text" wire:model="nombre" class="form-control">
                            @error('nombre')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Telefono Cliente</h6>
                            </label>
                            <input type="number" wire:model="celular" class="form-control">
                            @error('celular')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Fecha inicio plan</h6>
                            </label>
                            <input type="date" wire:model="fecha_inicio" class="form-control">
                            @error('fecha_inicio')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Fecha fin plan</h6>
                            </label>
                            <input type="date" wire:model="expiration_plan" class="form-control">
                            @error('expiration_plan')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    @if ($condicional == 'perfiles')
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>
                                    <h6>Perfil</h6>
                                </label>
                                <input type="text" wire:model="PerfilCliente" class="form-control">
                                @error('PerfilCliente')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>
                                    <h6>Pin</h6>
                                </label>
                                <input type="text" wire:model="PinCliente" class="form-control">
                                @error('PinCliente')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @elseif ($condicional == 'combos')
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label>
                                    <h6>Plataforma 1</h6>
                                </label>
                                <input type="text" disabled wire:model="plataforma1Nombre" class="form-control">
                                @error('plataforma1Nombre')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label>
                                    <h6>Nombre perfil 1</h6>
                                </label>
                                <input type="text" wire:model="perfil1COMBO" class="form-control">
                                @error('perfil1COMBO')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label>
                                    <h6>Pin perfil 1</h6>
                                </label>
                                <input type="text" wire:model="PIN1COMBO" class="form-control">
                                @error('PIN1COMBO')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label>
                                    <h6>Plataforma 2</h6>
                                </label>
                                <input type="text" disabled wire:model="plataforma2Nombre" class="form-control">
                                @error('plataforma2Nombre')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label>
                                    <h6>Nombre perfil 2</h6>
                                </label>
                                <input type="text" wire:model="perfil2COMBO" class="form-control">
                                @error('perfil2COMBO')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label>
                                    <h6>Pin perfil 2</h6>
                                </label>
                                <input type="text" wire:model="PIN2COMBO" class="form-control">
                                @error('PIN2COMBO')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label>
                                    <h6>Plataforma 3</h6>
                                </label>
                                <input type="text" disabled wire:model="plataforma3Nombre" class="form-control">
                                @error('plataforma3Nombre')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label>
                                    <h6>Nombre perfil 3</h6>
                                </label>
                                <input type="text" wire:model="perfil3COMBO" class="form-control">
                                @error('perfil3COMBO')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4">
                            <div class="form-group">
                                <label>
                                    <h6>Pin perfil 3</h6>
                                </label>
                                <input type="text" wire:model="PIN3COMBO" class="form-control">
                                @error('PIN3COMBO')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif
                </div>

                <div class="row">
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

                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <span>
                                <img src="{{ asset('storage/planesComprobantes/' . $comprobante) }}"
                                    alt="No tiene comprobante" height="500" width="750">
                            </span>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group custom-file">
                            <input type="file" class="custom-file-input form-control" wire:model="comprobante"
                                accept="image/x-png,image/gif,image/jpeg">
                            <label class="custom-file-label">Comprobante {{ $comprobante }}</label>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Telefono Cliente</h6>
                            </label>
                            <input type="number" wire:model="celular" class="form-control">
                            @error('celular')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Fecha inicio plan</h6>
                            </label>
                            <input type="date" wire:model="fecha_inicio" class="form-control">
                            @error('fecha_inicio')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Fecha fin plan</h6>
                            </label>
                            <input type="date" wire:model="expiration_plan" class="form-control">
                            @error('expiration_plan')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    @if ($condicional == 'perfiles')
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>
                                    <h6>Perfil</h6>
                                </label>
                                <input type="text" wire:model="PerfilCliente" class="form-control">
                                @error('PerfilCliente')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label>
                                    <h6>Pin</h6>
                                </label>
                                <input type="text" wire:model="PinCliente" class="form-control">
                                @error('PinCliente')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif

                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <span>
                                <img src="{{ asset('storage/planesComprobantes/' . $comprobante) }}"
                                    alt="No tiene comprobante" height="500" width="750">
                            </span>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group custom-file">
                            <input type="file" class="custom-file-input form-control" wire:model="comprobante"
                                accept="image/x-png,image/gif,image/jpeg">
                            <label class="custom-file-label">Comprobante {{ $comprobante }}</label>

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

                <div class="modal-footer">
                    <a href="javascript:void(0)" class="btn btn-dark" wire:click.prevent="Modificar()">Modificar</a>
                </div>
            </div>
        </div>
    </div>
</div>
