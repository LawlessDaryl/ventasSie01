<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog" style="overflow-y: scroll;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>{{ $componentName }}</b> | {{ $selected_id > 0 ? 'EDITAR' : 'CREAR' }}
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
           
            {{-- DATOS DE EMPLEADO --}}
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" wire:model.lazy="name" class="form-control" placeholder="Ingrese nombre">
                            @error('name') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input type="text" wire:model.lazy="lastname" class="form-control" placeholder="Ingrese apellidos">
                            @error('lastname') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>CI</label>
                            <input type="text" wire:model.lazy="ci" class="form-control" placeholder="Ingrese nro de Cedula de Indentidad">
                            @error('ci') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Sexo</label>
                            <select wire:model="genero" class="form-control">
                                <option value="Seleccionar" disabled>Elegir</option>
                                <option value="Masculino" selected>Masculino</option>
                                <option value="Femenino" selected>Femenino</option>
                            </select>
                            @error('genero') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Fecha de Nacimiento</label>
                            <input type="date" wire:model.lazy="dateNac" class="form-control">
                            @error('dateNac') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Direccion</label>
                            <input type="text" wire:model.lazy="address" class="form-control" placeholder="Ingrese direccion">
                            @error('address') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Telefono</label>
                            <input type="number" wire:model.lazy="phone" class="form-control" placeholder="Ingrese nro de telefono">
                            @error('phone') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Area de Trabajo</label>
                            <select wire:model="areaid" class="form-control">
                                <option value="Elegir" disabled>Elegir</option>
                                @foreach($areas as $area)
                                <option value="{{$area->id}}">{{$area->nameArea}}</option>
                                @endforeach
                            </select>
                            @error('areaid') <span class="text-danger er"> {{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Cargo</label>
                            <select wire:model="cargoid" class="form-control">
                                <option value="Elegir" disabled>Elegir</option>
                                @foreach($cargos as $cargo)
                                    <option value="{{$cargo->id}}">{{$cargo->name}}</option>
                                @endforeach
                            </select>
                            @error('cargoid') <span class="text-danger er"> {{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Estado Civil</label>
                            <select wire:model="estadoCivil" class="form-control">
                                <option value="Seleccionar" disabled>Elegir</option>
                                <option value="Soltero" selected>Soltero</option>
                                <option value="Casado" selected>Casado</option>
                            </select>
                            @error('genero') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Fecha de Inicio</label>
                            <input type="date" wire:model.lazy="fechaInicio" class="form-control">
                            @error('fechaInicio') <span class="text-danger er">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Contrato</label>
                            <br>
                            <div class="btn-group">
                                <select wire:model="contratoid" class="form-control col-md-12">
                                    <option value="Elegir" disabled>Elegir</option>
                                    @foreach($contratos as $contrato)
                                        <option value="{{$contrato->id}}">{{$contrato->descripcion}}</option>
                                    @endforeach
                                </select>
                                <a type="button" wire:click="NuevoContrato()" class="btn btn-warning close-btn text-info">Nuevo</a>
                            </div>
                        </div>
                        @error('contratoid') <span class="text-danger er"> {{ $message }}</span> @enderror
                    </div>

                    <div class="col-sm-12 mt-3">
                        <div class="form-group custom-file">
                            <input type="file" class="custom-file-input form-control img-thumbnail center-block" wire:model="image" accept="image/x-png, image/gif, image/jpeg">
                            <label for="" class="custom-file-label">Imagen {{$image}}</label>
                            {{--<h6 style="color: red">Seleccione una Imagen de 2Mb</h6>--}}
                            @error('image') <span class="text-danger er"> {{ $message }}</span> @enderror
                        </div>
                    </div>

                </div>
            </div>
           
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-warning close-btn text-info" data-dismiss="modal" style="background: #ee761c">CANCELAR</button>
                    @if ($selected_id < 1)
                        <button type="button" wire:click.prevent="Store()"
                            class="btn btn-warning close-btn text-info">GUARDAR</button>
                    @else
                        <button type="button" wire:click.prevent="Update()"
                            class="btn btn-warning close-btn text-info">ACTUALIZAR</button>
                    @endif
            </div>
        </div>
    </div>
</div>