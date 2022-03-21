<div wire:ignore.self class="modal fade" id="theDetail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #b3a8a8">
                <h5 class="modal-title text-white">
                    <b>DETALLE DEL SERVICIO TÉCNICO</b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body" style="background: #f0ecec">

                <div class="text-center">
                    <label>
                        <h5><b>CLIENTE: {{ $nombreCliente }}</b></h5>
                    </label><br />
                    <label>
                        <h6>Teléfono: {{ $celular }}</h6>
                    </label>
                </div>


                <div class="row mt-3 container">
                    <div class="col-sm-12 col-md-12">
                        <table cellpadding="2" cellspacing="2" width="100%">
                            <tr>
                                <td class="text-right" colspan="1">
                                    <label>
                                        <h6>Tipo de Trabajo: </h6>
                                    </label>
                                </td>
                                <td class="text-center" colspan="2">
                                    <select wire:model.lazy="typeworkid" class="form-control" disabled>
                                        <option value="Elegir" disabled selected>Elegir</option>

                                        @foreach ($work as $wor)
                                            <option value="{{ $wor->id }}" selected>{{ $wor->name }}</option>
                                        @endforeach

                                    </select>
                                    @error('typeworkid')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror

                                </td>
                                <td class="text-right" colspan="1">
                                    <label>
                                        <h6>Tipo de equipo: </h6>
                                    </label>
                                </td>
                                <td class="text-center" colspan="2">
                                    <select wire:model.lazy="catprodservid" class="form-control" disabled>
                                        <option value="Elegir" disabled selected>Elegir</option>
                                        @foreach ($cate as $cat)
                                            <option value="{{ $cat->id }}" selected>{{ $cat->nombre }}</option>
                                        @endforeach

                                    </select>
                                    @error('catprodservid')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror

                                </td>
                            </tr>

                            <tr>
                                <td class="text-right" colspan="1">
                                    <label>
                                        <h6>Marca/Modelo</h6>
                                    </label>
                                </td>
                                <td class="text-left" colspan="5">
                                    <datalist id="colores">
                                        @foreach ($marcas as $cat)
                                            <option value="{{ $cat->name }}" selected>{{ $cat->name }}</option>
                                        @endforeach
                                    </datalist>
                                    <input disabled list="colores" wire:model.lazy="marca" name="colores" type="text"
                                        class="form-control">

                                </td>
                            </tr>

                            <tr>
                                <td class="text-right">
                                    <label>
                                        <h6>Estado del Equipo</h6>
                                    </label>
                                </td>
                                <td class="text-left" colspan="5">
                                    <input disabled type="text" wire:model.lazy="detalle" class="form-control"
                                        placeholder="ej: Note 7 con protector de pantalla">
                                    @error('detalle')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>

                            <tr>
                                <td class="text-right">
                                    <label>
                                        <h6>Falla según el cliente</h6>
                                    </label>
                                </td>
                                <td class="text-left" colspan="5">
                                    <input disabled type="text" wire:model.lazy="falla_segun_cliente"
                                        class="form-control" placeholder="ej: Revisión">
                                    @error('falla_segun_cliente')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>

                            <tr>
                                <td class="text-right">
                                    <label>
                                        <h6>Diagnóstico</h6>
                                    </label>
                                </td>
                                <td class="text-left" colspan="5">
                                    <input type="text" wire:model.lazy="diagnostico" class="form-control"
                                        placeholder="ej: Revisión">
                                    @error('diagnostico')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>

                            <tr>
                                <td class="text-right">
                                    <label>
                                        <h6>Solución</h6>
                                    </label>
                                </td>
                                <td class="text-left" colspan="5">
                                    <input type="text" wire:model.lazy="solucion" class="form-control"
                                        placeholder="ej: Revisión">
                                    @error('solucion')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </td>
                            </tr>

                            <tr>
                                <td class="text-right">
                                    <label>
                                        <h6>Costo</h6>
                                    </label>
                                </td>
                                <td class="text-left">
                                    <input type="number" wire:model="costo" class="form-control"
                                        placeholder="ej: 0.0">
                                    @error('costo')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td class="text-left" colspan="4">
                                    <input type="text" wire:model.lazy="detalle_costo" class="form-control"
                                        placeholder="ej: Se compró una pantalla">
                                    @error('detalle_costo')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror

                                </td>
                            </tr>

                            <tr>
                                <td class="text-right">
                                    <label>
                                        <h6>Total</h6>
                                    </label>
                                </td>
                                <td class="text-left">
                                    <input type="number" wire:model="import" class="form-control"
                                        placeholder="ej: 0.0">
                                    @error('import')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </td>

                                <td class="text-right">
                                    <label>
                                        <h6>A Cuenta</h6>
                                    </label>
                                </td>
                                <td class="text-left">
                                    <input type="number" wire:model="on_account" class="form-control"
                                        placeholder="ej: 0.0">
                                    @error('on_account')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </td>

                                <td class="text-right">
                                    <label>
                                        <h6>Saldo</h6>
                                    </label>
                                </td>
                                <td class="text-left">
                                    <input type="number" wire:model.lazy="saldo" class="form-control"
                                        placeholder="ej: 0.0" disabled>
                                    @error('saldo')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </td>

                            </tr>

                            <tr>
                                <td class="text-right">
                                    <label>
                                        <h6>Fecha Entrega</h6>
                                    </label>
                                </td>
                                <td class="text-left" colspan="2">
                                    <input type="date" wire:model.lazy="fecha_estimada_entrega" class="form-control">
                                    @error('fecha_estimada_entrega')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </td>
                                <td class="text-left">
                                    <label>
                                        <h6>Hora Entrega</h6>
                                    </label>
                                </td>
                                <td class="text-left" colspan="2">
                                    <input type="time" name="hora_entrega" wire:model.lazy="hora_entrega"
                                        class="form-control">
                                </td>

                            </tr>


                        </table>
                    </div>
                </div>


            </div>

            <div class="modal-footer" style="background: #f0ecec">

                @if ($proceso)
                    <button type="button" wire:click.prevent="CambioProceso({{ $service1 }})"
                        class="btn btn-dark close-btn text-info" data-dismiss="modal"
                        style="background: #3b3f5c">REGISTRAR TERMINADO</button>
                @endif

                @if ($selected_id < 1)
                    <button type="button" wire:click.prevent="GuardarCambio({{ $service1 }})"
                        class="btn btn-dark close-btn text-info">REGISTRAR INFORMACIÓN</button>
                @else
                    <button type="button" wire:click.prevent="Update()"
                        class="btn btn-dark close-btn text-info">ACTUALIZAR</button>
                @endif
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                    data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>


            </div>
        </div>
    </div>
</div>
