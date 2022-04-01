<div wire:ignore.self class="modal fade" id="modalDetails" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white">
                    <b style="color:black">Detalle de Transacción # {{ $transaccionId }}</b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover mt-1">
                        <thead class="text-white" style="background: #3b3ff5;">
                            <tr>
                                <th class="table-th text-center text-white">Tipo</th>
                                <th class="table-th text-center text-white">Cantidad</th>
                                <th class="table-th text-center text-white">Cartera</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($details as $d)
                                <tr>
                                    <td class="text-center">
                                        <h6>{{ $d->tipo }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $d->importe }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $d->nombreCartera }}</h6>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Observaciones: </label><br>
                            <label>
                                @if (!empty($details))
                                    {{ $details[0]->observaciones }}
                                @endif
                            </label>
                            @error('estado') <span class="text-danger er">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark close-btn text-info" data-dismiss="modal">CANCELAR</button>
            </div>
        </div>
    </div>
</div>
