<div wire:ignore.self class="modal fade" id="editarservicio" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">
                    <b>Editar Servicio</b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">

                <div class="text-center">
                    <label>
                        <h5><b>{{strtoupper($this->nombrecliente)}}</b> {{$this->celularcliente}}</h5>
                    </label>
                </div>


                <form class="needs-validation" novalidate>
                    {{-- <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip01">Tipo de Trabajo</label>
                            <select class="custom-select form-control" required>
                                <option value="">Abrir este menú de selección</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltip02">Tipo de Equipo</label>
                            <select class="custom-select form-control" required>
                                <option value="">Abrir este menú de selección</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="validationTooltipUsername">Marca/Modelo</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="validationTooltipUsername" placeholder="Huawei, Samsung, etc..." aria-describedby="validationTooltipUsernamePrepend" required>
                            </div>
                        </div>
                    </div> --}}

                    

                    <div class="form-row">
                        <div class="form-row" style="width: 33.33%; margin-right: 7px;">
                            <div class="col-md-12">
                                <label for="validationTooltip01">Tipo de Trabajo</label>
                                <select class="custom-select form-control" required>
                                    <option value="">Seleccionar</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row" style="width: 33.33%; margin-right: 7px;">
                            <div class="col-md-12">
                                <label for="validationTooltip01">Tipo de Equipo</label>
                                    <select class="custom-select form-control" required>
                                        <option value="">Seleccionar</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                            </div>
                        </div>
                        <div class="form-row" style="width: 33.33%">
                            <div class="col-md-12">
                                <label for="validationTooltipUsername">Marca/Modelo</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="validationTooltipUsername" placeholder="Huawei, Samsung, etc..." aria-describedby="validationTooltipUsernamePrepend" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>


                    <div class="form-row">
                        <div class="col-md-12">
                            <label for="validationTooltipUsername">Detalle Equipo</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="validationTooltipUsername" placeholder="Redmi Note 4 Blanco, Huawei Y9 Prime Azul, Portatil Asus sin Cable, Samsung A11 Color Plomo Oscuro, etc..." aria-describedby="validationTooltipUsernamePrepend" required>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 10px;">
                            <label for="validationTooltipUsername">Falla Según Cliente</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="validationTooltipUsername" placeholder="No Funciona Internet, No Carga No Enciende, No da el tecla encendido, etc..." aria-describedby="validationTooltipUsernamePrepend" required>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 10px;">
                            <label for="validationTooltipUsername">Diagnóstico Previo</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="validationTooltipUsername" placeholder="Configurar Apn, Probar Otro Cable de Carga, Cambiar Tecla Encendido, etc..." aria-describedby="validationTooltipUsernamePrepend" required>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: 10px;">
                            <label for="validationTooltipUsername">Solución</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="validationTooltipUsername" placeholder="Configurar Apn, Probar Otro Cable de Carga, Cambiar Tecla Encendido, etc..." aria-describedby="validationTooltipUsernamePrepend" required>
                            </div>
                        </div>
                    </div>
                    <br>

                    
                    <div class="form-row">
                        <div class="form-row" style="width: 35%; margin-right: 7px;">
                            <div class="col-md-12">
                                <label for="validationTooltip01">Fecha de Entrega</label>
                                <input type="date" wire:model.lazy="fecha_estimada_entrega" class="form-control">
                            </div>
                        </div>
                        <div class="form-row" style="width: 25%; margin-right: 7px;">
                            <div class="col-md-12">
                                <label for="validationTooltip01">Hora de Entrega</label>
                                <input type="time" name="hora_entrega" wire:model.lazy="hora_entrega" class="form-control">
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="form-row">
                        <div class="form-row" style="width: 33.33%; margin-right: 7px;">
                            <div class="col-md-12">
                                <label for="validationTooltip01">Precio del Servicio Bs</label>
                                <select class="custom-select form-control" required>
                                    <option value="">Seleccionar</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row" style="width: 33.33%; margin-right: 7px;">
                            <div class="col-md-12">
                                <label for="validationTooltip01">A Cuenta Bs</label>
                                    <select class="custom-select form-control" required>
                                        <option value="">Seleccionar</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                            </div>
                        </div>
                        <div class="form-row" style="width: 33.33%">
                            <div class="col-md-12">
                                <label for="validationTooltipUsername">Saldo Bs</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="validationTooltipUsername" placeholder="Huawei, Samsung, etc..." aria-describedby="validationTooltipUsernamePrepend" required>
                                </div>
                            </div>
                        </div>
                    </div>




                    {{-- <div class="form-row">
                      <div class="col-md-12">
                        <label for="validationTooltip03">Estado del Equipo</label>
                        <input type="text" class="form-control" id="validationTooltip03" placeholder="" required>
                        <div class="invalid-tooltip">
                          Please provide a valid city.
                        </div>
                      </div>
                      <div class="col-md-3 mb-3">
                        <label for="validationTooltip04">State</label>
                        <input type="text" class="form-control" id="validationTooltip04" placeholder="State" required>
                        <div class="invalid-tooltip">
                          Please provide a valid state.
                        </div>
                      </div>
                      <div class="col-md-3 mb-3">
                        <label for="validationTooltip05">Zip</label>
                        <input type="text" class="form-control" id="validationTooltip05" placeholder="Zip" required>
                        <div class="invalid-tooltip">
                          Please provide a valid zip.
                        </div>
                      </div>
                    </div> --}}
                  </form>


            </div>

            <div class="modal-footer">
                
                <button type="button" class="btn btn-secondary">Cancelar Servicio</button>
                <button type="button" class="btn btn-success">Guardar Servicio</button>

            </div>
        </div>
    </div>
</div>
