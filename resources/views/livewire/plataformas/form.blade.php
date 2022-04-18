<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>{{ $componentName }}</b> | {{ $selected_id > 0 ? 'EDITAR' : 'CREAR' }}
                </h5>
                <h6 class="text-center text-warning" wire:loading wire:target="Store, image">POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>
                                <h6>Nombre</h6>
                            </label>
                            <input type="text" wire:model="nombre" class="form-control" placeholder="ej: Magis">
                            @error('nombre')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label>
                                <h6>Precio Entera</h6>
                            </label>
                            <input type="text" wire:model="precioEntera" class="form-control" placeholder="ej: 100">
                            @error('precioEntera')
                                <span class=" text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label>
                                <h6>Precio Perfil</h6>
                            </label>
                            <input type="text" wire:model="precioPerfil" class="form-control" placeholder="ej: 30">
                            @error('precioPerfil')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>
                                <h6>Estado</h6>
                            </label>
                            <select wire:model='status' class="form-control">
                                <option value="ACTIVO">ACTIVO</option>
                                <option value="BLOQUEADO">BLOQUEADO</option>
                            </select>
                            @error('status')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>
                                <h6>Tipo</h6>
                            </label>
                            <select wire:model='tipo' class="form-control">
                                <option value="CORREO" selected>CORREO</option>
                                <option value="USUARIO">USUARIO</option>
                            </select>
                            @error('tipo')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label>
                                <h6>Perfiles</h6>
                            </label>
                            <select wire:model='perfiles_si_no' class="form-control">
                                <option value="SI" selected>SI</option>
                                <option value="NO">NO</option>
                            </select>
                            @error('tipo')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <div class="form-group">
                            <label>
                                <h6>Descripción</h6>
                            </label>
                            <input type="text" wire:model="description" class="form-control"
                                placeholder="ej: Deportes, Cultura, Cine, Series">
                            @error('description')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <div class="form-group custom-file">
                            <input type="file" class="custom-file-input form-control" wire:model="image"
                                accept="image/x-png,image/gif,image/jpeg">
                            <label class="custom-file-label">Imagen {{ $image }}</label>
                        </div>
                    </div>
                    {{-- <a href="javascript:void(0)" wire:click="$set('status','Elegir')"
                        class="btn btn-dark mtmobile" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a> --}}
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                    data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>
                @if ($selected_id < 1)
                    <button type="button" wire:click.prevent="Store()" wire:loading.attr="disabled"
                        wire:target="image, Store" class="btn btn-dark close-btn text-info">GUARDAR</button>
                @else
                    <button type="button" wire:click.prevent="Update()"
                        class="btn btn-dark close-btn text-info">ACTUALIZAR</button>
                @endif
            </div>
        </div>
    </div>
</div>
