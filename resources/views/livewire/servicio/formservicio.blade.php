<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">
                    <b>Nuevo servicio de la Orden Nº {{ $orderservice == '0' ? 'NO DEFINIDO' : $orderservice }} </b>
                    | {{ $selected_id > 0 ? 'EDITAR' : 'CREAR' }}
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">



                <div class="form-row">
                    <div class="form-row" style="width: 33.33%; margin-right: 7px;">
                        <div class="col-md-12">
                            <label for="validationTooltip01">Tipo de Trabajo</label>
                            <select class="custom-select form-control" wire:model.lazy="typeworkid" required>
                                <option value="Elegir" disabled selected>Elegir</option>
                                @foreach ($work as $wor)
                                    @if($wor->status=='ACTIVE')
                                        <option value="{{ $wor->id }}">{{ ucwords(strtolower($wor->name)) }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('typeworkid')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                        
                    </div>
                    <div class="form-row" style="width: 33.33%; margin-right: 7px;">
                        <div class="col-md-12">
                            <label for="validationTooltip01">Categoría Trabajo</label>
                                <select class="custom-select form-control" wire:model.lazy="catprodservid"  required>
                                    <option value="Elegir" disabled selected>Elegir</option>
                                    @foreach ($cate as $cat)
                                        @if($cat->estado == 'ACTIVO')
                                            <option value="{{ $cat->id }}" selected>{{ ucwords(strtolower($cat->nombre)) }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('catprodservid')
                                <span class="text-danger er">{{ $message }}</span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-row" style="width: 33.33%">
                        <div class="col-md-12">
                            <label for="validationTooltipUsername">Marca/Modelo</label>
                            <div class="input-group">
                                <datalist id="marca">
                                    @foreach ($marcas as $cat)
                                        <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                                    @endforeach
                                </datalist>
                                <input list="marca" type="text" wire:model.lazy="marc" class="form-control"  placeholder="Huawei, Samsung, etc..." required>
                            </div>
                            @error('marc')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <br>


                <div class="form-row">
                    <div class="form-row" style="width: 42%; margin-right: 7px;">
                
                        <div class="col-md-12">
                            <label for="validationTooltipUsername">Detalle Equipo</label>
                            <div class="input-group">
                                <input type="text" wire:model.lazy="detalle" class="form-control"  placeholder="Redmi Note 4 Blanco, Huawei Y9 Prime Azul, Portatil Asus sin Cable, Samsung A11 Color Plomo Oscuro, etc..." required>
                            </div>
                            @error('detalle')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                        
                    </div>
                    <div class="form-row" style="width: 32%; margin-right: 7px;">
                        <div class="col-md-12">
                            <label for="validationTooltip01">Fecha de Entrega</label>
                            <input type="date" wire:model.lazy="fecha_estimada_entrega" class="form-control">
                        </div>
                    </div>
                    <div class="form-row" style="width: 25%">
                        <div class="col-md-12">
                            <label for="validationTooltip01">Hora</label>
                            <input type="time" wire:model.lazy="hora_entrega" class="form-control">
                        </div>
                    </div>
                </div>




                <div class="form-row">
                    <div class="col-md-12" style="margin-top: 10px;">
                        <label for="validationTooltipUsername">Falla Según Cliente</label>
                        <div class="input-group">
                            <input type="text" wire:model.lazy="falla_segun_cliente" class="form-control"  placeholder="No Funciona Internet, No Carga, No Enciende, etc..." required>
                        </div>
                        @error('falla_segun_cliente')
                                <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-12" style="margin-top: 10px;">
                        <label for="validationTooltipUsername">Diagnóstico Previo</label>
                        <div class="input-group">
                            <input type="text" wire:model.lazy="diagnostico" class="form-control"  placeholder="Configurar Apn, Probar Otro Cable de Carga, Cambiar Tecla Encendido, etc..." required>
                        </div>
                        @error('diagnostico')
                                <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-12" style="margin-top: 10px;">
                        <label for="validationTooltipUsername">Solución</label>
                        <div class="input-group">
                            <input type="text" wire:model.lazy="solucion" class="form-control"  placeholder="Se Cambio el Socalo, Se Limpio la Placa, Se Reinstalo el Sistema Operativo etc..." required>
                        </div>
                        @error('solucion')
                                <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <br>


                <div class="form-row">
                    <div class="form-row" style="width: 33.33%; margin-right: 7px;">
                        <div class="col-md-12">
                            <label for="validationTooltip01">Precio del Servicio Bs</label>
                            <input type="number" wire:model.lazy="import" class="form-control">
                        </div>
                        @error('import')
                                <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-row" style="width: 33.33%; margin-right: 7px;">
                        <div class="col-md-12">
                            <label for="validationTooltip01">A Cuenta Bs</label>
                            <input type="number" wire:model="on_account" class="form-control">
                            @error('on_account') <span class="text-danger er">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="form-row text-center" style="width: 33.33%">
                        <div class="col-md-12">
                            <label><h6>Saldo</h6></label>
                                <input type="number" wire:model.lazy="saldo" class="form-control text-center" placeholder="ej: 0.0" disabled>
                                @error('saldo') <span class="text-danger er">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>



                <div class="form-row">
                    <div class="form-row" style="width: 25%; margin-right: 7px;">
                    </div>
                    <div class="form-row" style="width: 50%; margin-right: 7px;">
                        <div class="col-md-12 text-center">
                            <label><h6>Técnico Receptor</h6></label>
                            <select wire:model="userId" class="form-control" style="font-size: 90%">
                                <option value="0" disabled selected>Seleccione técnico</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row text-center" style="width: 25%">
                    </div>
                </div>







                <div class="row">

                    @if($selected_id > 0)
                    @if($opciones != 'ENTREGADO')
                    <div class="col-lg-5 col-sm-12 col-md-4">
                            <label><h6>Estado del Servicio</h6></label>
                            <select wire:model.lazy="opciones" class="form-control">
                                @if($estatus == 'PENDIENTE')
                                    <option value="PENDIENTE" >PENDIENTE</option>
                                @endif
                                @if($estatus == 'PROCESO')
                                    <option value="PENDIENTE" >PENDIENTE</option>
                                    <option value="PROCESO" >PROCESO</option>
                                @endif
                                @if($estatus == 'TERMINADO' )
                                    <option value="PENDIENTE" >PENDIENTE</option>
                                    <option value="PROCESO" >PROCESO</option>
                                    <option value="TERMINADO" >TERMINADO</option>
                                @endif
                                @if($estatus == 'ABANDONADO' )
                                    <option value="PENDIENTE" >PENDIENTE</option>
                                    <option value="PROCESO" >PROCESO</option>
                                    <option value="TERMINADO" >TERMINADO</option>
                                    <option value="ABANDONADO" >ABANDONADO</option>
                                @endif
                            </select>
                            @error('opciones') <span class="text-danger er">{{ $message }}</span>@enderror
                        </div>
                        @endif
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click.prevent="resetUI()" class="btn btn" style="background-color: rgb(0, 56, 161); color: beige;"
                        data-dismiss="modal">CANCELAR</button>
                    @if ($selected_id < 1)
                        <button type="button" wire:click.prevent="Store()"
                        class="btn btn" style="background-color: rgb(0, 145, 19); color: beige;">GUARDAR</button>
                    @else
                        <button type="button" wire:click.prevent="Update()"
                        class="btn btn" style="background-color: rgb(0, 85, 124); color: beige;">ACTUALIZAR</button>
                    @endif


                </div>
            </div>
        </div>
    </div>
</div>
