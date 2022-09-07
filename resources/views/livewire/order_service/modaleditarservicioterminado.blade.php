<div wire:ignore.self class="modal fade" id="editarservicioterminado" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white">
                    Editar Servicio Terminado - Orden de Servicio N°:{{$this->id_orden_de_servicio}}
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">

                <form class="needs-validation">

                    @if (Auth::user()->hasPermissionTo('Cambiar_Tecnico_Responsable'))

                        <div class="form-row">
                            {{-- <div class="form-row" style="width: 25%; margin-right: 7px;">
                                
                            </div> --}}
                            <div class="form-row" style="width: 50%; margin-right: 7px;">
                                <div class="col-md-12 text-center">
                                    <label for="validationTooltip01">Cambiar Técnico Responsable</label>
                                    <select wire:model="id_usuario" class="form-control">
                                        @foreach($this->lista_de_usuarios as $i)
                                        <option value="{{$i->idusuario}}">{{$i->nombreusuario}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            @if($this->estadocaja == "abierto")
                            <div class="form-row text-center" style="width: 50%">
                                <div class="col-md-12 text-center">
                                    <label for="validationTooltip01">Cambiar Tipo de Pago</label>
                                    <select wire:model="edit_carteraservicioterminado" class="form-control">
                                        @foreach ($listacarteras as $cartera)
                                        <option value="{{$cartera->idcartera}}">{{ucwords(strtolower($cartera->nombrecartera)) .' - ' .ucwords(strtolower($cartera->dc))}}</option>
                                        @endforeach
                                        @foreach ($listacarterasg as $carteras)
                                        <option value="{{$carteras->idcartera}}">{{ucwords(strtolower($carteras->nombrecartera)) .' - ' .ucwords(strtolower($carteras->dc))}}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                            @endif
                        </div>

                    <br>
                    @endif

                    <div class="form-row">
                        <div class="form-row" style="width: 33.33%; margin-right: 7px;">
                            <div class="col-md-12">
                                <label for="validationTooltip01">Precio del Servicio Bs</label>
                                <input type="number" wire:model.lazy="edit_precioservicioterminado" class="form-control">
                            </div>
                            @error('edit_precioservicioterminado')
                                    <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-row" style="width: 33.33%; margin-right: 7px;">
                            <div class="col-md-12">
                                <label for="validationTooltip01">A Cuenta Bs</label>
                                <input type="number" wire:model="edit_acuentaservicioterminado" class="form-control">
                            </div>
                        </div>
                        <div class="form-row text-center" style="width: 33.33%">
                            <div class="col-md-12">
                                <label>Saldo Bs</label>
                                <div class="text-center">
                                    <label for="validationTooltipUsername"> <h2>{{number_format($this->edit_saldoterminado,2)}}</h2> </label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <br>
                    

                    <div class="form-row">
                        <div class="form-row" style="width: 30%; margin-right: 7px;">
                            <div class="col-md-12">
                                <label for="validationTooltip01">Costo del Servicio Bs</label>
                                <input type="number" wire:model.lazy="edit_costoservicioterminado" class="form-control">
                            </div>
                        </div>
                        <div class="form-row" style="width: 67%; margin-right: 7px;">
                            <div class="col-md-12">
                                <label for="validationTooltip01">Motivo del Costo</label>
                                <input type="text" wire:model.lazy="edit_motivoservicioterminado" class="form-control">
                            </div>
                        </div>
                    </div>


                  </form>


            </div>

            <div class="modal-footer">
                
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" wire:click="actualizarservicioterminado()">Actualizar</button>
                
            </div>
        </div>
    </div>
</div>