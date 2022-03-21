<div wire:ignore.self class="modal fade" id="theDetalleEntrega" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>REGISTRAR SERVICIO TÉCNICO</b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">
                <div class = "row">
                <div class ="col-sm-12 col-md-6">
                    <div class="text-center">
                        <label><h5><b>CLIENTE: {{ $nombreCliente }}</b></h5></label><br/>
                        <label><h6>Teléfono: {{ $celular }}</h6></label>
                    </div>
                </div>
                    <div class ="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Tipo de pago</label>
                            <select wire:model="tipopago" class="form-control">
                                <option value="EFECTIVO" selected>EFECTIVO</option>
                                <option value="Banco">CUENTA BANCARIA</option>
                                <option value="TigoStreaming">TIGO MONEY</option>
                            </select>
                            @error('tipopago')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                
            <div class="row mt-3 container">
                <div class="col-sm-12 col-md-12">
                    <table cellpadding="2" cellspacing="2" width="100%">
                        
                        <tr>
                            <td class="text-right" >
                                <label><h6>Total</h6></label>
                            </td>
                            <td class="text-left" >
                                <input type="number" wire:model="import" class="form-control" placeholder="ej: 0.0">
                                    @error('import') <span class="text-danger er">{{ $message }}</span>@enderror
                            </td>
                        
                            <td class="text-right" >
                                <label><h6>A Cuenta</h6></label>
                            </td>
                            <td class="text-left" >
                                <input type="number" wire:model="on_account" class="form-control"
                                placeholder="ej: 0.0">
                                @error('on_account') <span class="text-danger er">{{ $message }}</span>@enderror
                            </td>

                            <td class="text-right" >
                                <label><h6>Saldo</h6></label>
                            </td>
                            <td class="text-left" >
                                <input type="number" wire:model.lazy="saldo" class="form-control" placeholder="ej: 0.0" disabled>
                                @error('saldo') <span class="text-danger er">{{ $message }}</span>@enderror
                            </td>

                        </tr>

                        <tr>
                            <td class="text-right" >
                                <label><h6>Fecha Entrega</h6></label>
                            </td>
                            <td class="text-left" colspan="2">
                                <input type="date" wire:model.lazy="fecha_estimada_entrega" class="form-control" disabled>
                                @error('fecha_estimada_entrega')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </td>
                            <td class="text-left">
                                <label><h6>Hora Entrega</h6></label>
                            </td>
                            <td class="text-left" colspan="2">
                                <input type="time" name="hora_entrega" wire:model.lazy="hora_entrega"
                                class="form-control" disabled>
                            </td>

                        </tr>



                    </table>
                </div>
            </div>
                  

            </div>

            <div class="modal-footer">
               
               
                        <button type="button" wire:click.prevent="CambioTerminado({{$service1}})" class="btn btn-dark close-btn text-info"
                            data-dismiss="modal" style="background: #3b3f5c">REGISTRAR ENTREGADO</button>
                
             
                    <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                        data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>
                   


            </div>
        </div>
    </div>
</div>

