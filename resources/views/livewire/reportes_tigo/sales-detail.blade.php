<div wire:ignore.self class="modal fade" id="modalDetails" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: #414141">
                <h5 class="modal-title text-white">
                    <b>Detalle de Transacción # {{ $transaccionId }}</b>
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
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
                            <h6>Observaciones de la transacción: </h6><br>
                            <h6>
                                @if (!empty($details))
                                    {{ $details[0]->observaciones }}
                                @endif
                            </h6>
                            @error('estado')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
