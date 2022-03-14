<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #414141">
                <h5 class="modal-title text-white">
                    <b>{{ $componentName }}</b> | {{ $selected_id > 0 ? 'EDITAR' : 'CREAR' }}
                </h5>
                <h6 class="text-center text-warning" wire:loading wire:target="Store, image">POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body" style="background: #f0ecec">

                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" wire:model="nombre" class="form-control" placeholder="ej: Magis">
                            @error('nombre')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Descripción</label>
                            <input type="text" wire:model="description" class="form-control"
                                placeholder="Deportes, Cultura, Cine, Series">
                            @error('description')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Precio Entera</label>
                            <input type="text" wire:model="precioEntera" class="form-control" placeholder="ej: Magis">
                            @error('precioEntera')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Precio Perfil</label>
                            <input type="text" wire:model="precioPerfil" class="form-control" placeholder="ej: Magis">
                            @error('precioPerfil')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Estado</label>
                            <select wire:model='status' class="form-control">
                                <option value="Elegir" disabled>Elegir</option>
                                <option>ACTIVO</option>
                                <option>BLOQUEADO</option>
                            </select>
                            @error('status')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-8">
                        <div class="form-group custom-file">
                            <input type="file" class="custom-file-input form-control" wire:model="image"
                                accept="image/x-png,image/gif,image/jpeg">
                            <label class="custom-file-label">Imagen {{ $image }}</label>
                        </div>
                    </div>
                    <a href="javascript:void(0)" wire:click="$set('status','Elegir')"
                        class="btn btn-dark mtmobile" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>

            </div>
            <div class="modal-footer" style="background: #f0ecec">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                    data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>
                @if ($selected_id < 1)
                    <button type="button" wire:click="Store" wire:loading.attr="disabled" wire:target="image, Store"
                        class="btn btn-dark close-btn text-info">GUARDAR</button>
                @else
                    <button type="button" wire:click.prevent="Update()"
                        class="btn btn-dark close-btn text-info">ACTUALIZAR</button>
                @endif


            </div>
        </div>
    </div>
</div>
