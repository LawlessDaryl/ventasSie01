<div wire:ignore.self class="modal fade" id="theDetail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #b3a8a8">
                <h5 class="modal-title text-white">
                    <b>REGISTRAR SERVICIO TÉCNICO{{ $orderservice == '0' ? 'NO DEFINIDO' : $orderservice }} </b>
                    | {{ $selected_id > 0 ? 'EDITAR' : 'FINALIZADO' }}
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body" style="background: #f0ecec">

                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-6">
                        <div class="text-center">
                            <label><h5><b>CLIENTE: {{ $nombreCliente }}</b></h5></label><br/>
                            <label><h6>Teléfono: {{ $celular }}</h6></label>
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-6">
                        <div class="form-group row">
                            <div class="col-lg-3 col-sm-12 col-md-6">
                                <label>Tipo de Trabajo</label>
                            </div>
                            <div class="col-lg-9 col-sm-12 col-md-6">
                                <select wire:model.lazy="typeworkid" class="form-control">
                                    <option value="Elegir" disabled selected>Elegir</option>

                                    @foreach ($work as $wor)
                                        <option value="{{ $wor->id }}" selected>{{ $wor->name }}</option>
                                    @endforeach

                                </select>
                                @error('typeworkid') <span class="text-danger er">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-sm-12 col-md-6">
                        <div class="form-group row">
                            <div class="col-lg-3 col-sm-12 col-md-6">
                                <label>Tipo de equipo</label>
                            </div>
                            <div class="col-lg-9 col-sm-12 col-md-6">
                                <select wire:model.lazy="catprodservid" class="form-control">
                                    <option value="Elegir" disabled selected>Elegir</option>

                                    @foreach ($cate as $cat)
                                        <option value="{{ $cat->id }}" selected>{{ $cat->nombre }}</option>
                                    @endforeach

                                </select>
                                @error('catprodservid') <span class="text-danger er">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-sm-12 col-md-6">
                        <div class="form-group row">
                            <div class="col-lg-3 col-sm-12 col-md-6">
                                <label>Marca/Modelo</label>
                            </div>
                            <div class="col-lg-9 col-sm-12 col-md-6">
                                <datalist id="colores">
                                @foreach ($marcas as $cat)
                                    <option value="{{ $cat->name }}" selected>{{ $cat->name }}</option>
                                @endforeach
                                </datalist>
                                <input list="colores" wire:model.lazy="marca" name="colores" type="text" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-sm-12 col-md-12">
                        <div class="form-group row">
                            <div class="col-lg-3 col-sm-12 col-md-6">
                                <label>Estado del Equipo</label>
                            </div>
                            <div class="col-lg-9 col-sm-12 col-md-6">
                            <input type="text" wire:model.lazy="detalle" class="form-control"
                                placeholder="ej: Note 7 con protector de pantalla">
                            @error('detalle') <span class="text-danger er">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-12 col-sm-12 col-md-8">
                        <div class="form-group row">
                            <div class="col-lg-3 col-sm-12 col-md-6">
                                <label>Falla según el cliente</label>
                            </div>
                            <div class="col-lg-9 col-sm-12 col-md-6">
                            <input type="text" wire:model.lazy="falla_segun_cliente" class="form-control"
                                placeholder="ej: Revisión">
                                @error('falla_segun_cliente') <span class="text-danger er">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-sm-12 col-md-8">
                        <div class="form-group row">
                            <div class="col-lg-3 col-sm-12 col-md-6">
                                <label>Diagnóstico</label>
                            </div>
                            <div class="col-lg-9 col-sm-12 col-md-6">
                                <input type="text" wire:model.lazy="diagnostico" class="form-control"
                                    placeholder="ej: Revisión">
                                @error('diagnostico') <span class="text-danger er">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-sm-12 col-md-8">
                        <div class="form-group row">
                            <div class="col-lg-3 col-sm-12 col-md-6">
                                <label>Solución</label>
                            </div>
                            <div class="col-lg-9 col-sm-12 col-md-6">
                                <input type="text" wire:model.lazy="solucion" class="form-control"
                                    placeholder="ej: Revisión">
                                @error('solucion') <span class="text-danger er">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-12 col-md-4">
                        <div class="form-group row">
                            <div class="col-lg-3 col-sm-12 col-md-6">
                                <label>Total</label>
                            </div>
                            <div class="col-lg-8 col-sm-12 col-md-6">
                                <input type="number" wire:model="import" class="form-control" placeholder="ej: 0.0">
                                @error('import') <span class="text-danger er">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group row">
                            <div class="col-lg-3 col-sm-12 col-md-6">
                                <label>A Cuenta</label>
                            </div>
                            <div class="col-lg-8 col-sm-12 col-md-6">
                                <input type="number" wire:model="on_account" class="form-control"
                                    placeholder="ej: 0.0">
                                @error('on_account') <span class="text-danger er">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-12 col-md-4">
                        <div class="form-group row">
                            <div class="col-lg-3 col-sm-12 col-md-6">
                                <label>Saldo</label>
                            </div>
                            <div class="col-lg-8 col-sm-12 col-md-6">
                                <input type="number" wire:model.lazy="saldo" class="form-control" placeholder="ej: 0.0" disabled>
                                @error('saldo') <span class="text-danger er">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-4 col-sm-12 col-md-4">
                        <div class="form-group row">
                            <div class="col-lg-3 col-sm-12 col-md-6">
                                <label>Fecha Entrega</label>
                            </div>
                            <div class="col-lg-9 col-sm-12 col-md-6">
                                <input type="date" wire:model.lazy="fecha_estimada_entrega" class="form-control">
                                @error('fecha_estimada_entrega')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 col-sm-12 col-md-4">
                        <div class="form-group row">
                            <div class="col-lg-4 col-sm-12 col-md-6">
                                <label>Hora Entrega</label>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-md-6">
                                <input type="time" name="hora_entrega" wire:model.lazy="hora_entrega"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal-footer" style="background: #f0ecec">
                    <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                        data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>
                    @if ($selected_id < 1)
                        <button type="button" wire:click.prevent="Store()"
                            class="btn btn-dark close-btn text-info">GUARDAR</button>
                    @else
                        <button type="button" wire:click.prevent="Update()"
                            class="btn btn-dark close-btn text-info">ACTUALIZAR</button>
                    @endif


                </div>
            </div>
        </div>
    </div>
</div>
