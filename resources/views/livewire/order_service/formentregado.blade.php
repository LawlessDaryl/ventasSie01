<div wire:ignore.self class="modal fade" id="theEndDetail" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #b3a8a8">
                <h5 class="modal-title text-white">
                    <b>DETALLE DEL SERVICIO ENTREGADO</b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body" style="background: #f0ecec">
                    <div class="text-center">
                        <label><h5><b>CLIENTE: {{ $nombreCliente }}</b></h5></label><br/>
                        <label><h6>Teléfono: {{ $celular }}</h6></label>
                    </div>
                <div class="row mt-3 container">
                    <div class="col-sm-12 col-md-12">
                        <table cellpadding="2" cellspacing="2" width="100%">
                            <tr>
                                <td class="text-right" >
                                    <label><h6>Costo</h6></label>
                                </td>
                                <td class="text-left">
                                    <input type="number" wire:model="costo" class="form-control" placeholder="ej: 0.0">
                                    @error('costo') <span class="text-danger er">{{ $message }}</span>@enderror
                                </td>
                                <td class="text-left" colspan="4">
                                    <input type="text" wire:model.lazy="detalle_costo" class="form-control"
                                        placeholder="ej: Se compró una pantalla">
                                        @error('detalle_costo') <span class="text-danger er">{{ $message }}</span>@enderror
                                </td>
                            </tr> 
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
                        </table>
                    </div>
                </div>
            </div>
            

            <div class="modal-footer" style="background: #f0ecec">
                <button type="button" wire:click.prevent="GuardarCambio({{$service1}})"
                    class="btn btn-dark close-btn text-info">REGISTRAR INFORMACIÓN</button>
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                    data-dismiss="modal" style="background: #3b3f5c">CANCELAR</button>
            </div>
        </div>
    </div>
</div>

