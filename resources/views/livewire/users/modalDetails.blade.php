<div wire:ignore.self id="modal-details" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Historial Sucursales</b>
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="row">

                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <h6>Cambiar de sucursal</h6>
                            <select wire:model='sucursalUsuario' class="form-control">
                                <option value="Elegir" disabled>Elegir</option>
                                @foreach ($sucursales as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                            @error('sucursalUsuario')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 mt-4">
                        <a href="javascript:void(0)" class="btn btn-dark" wire:click.prevent="Cambiar()">ASIGNAR NUEVA
                            SUCURSAL</a>
                    </div>

                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover mt-1">
                        <thead class="text-white" style="background: #3b3ff5;">
                            <tr>
                                <th class="table-th text-center text-white">FECHA INICIO</th>
                                <th class="table-th text-center text-white">FECHA FIN</th>
                                <th class="table-th text-center text-white">SUCURSAL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $d)
                                <tr
                                    style="{{ $d->fecha_fin == null ? 'background-color: lightgreen !important' : '  ' }}">
                                    <td class="text-center">
                                        <h6>
                                            {{ \Carbon\Carbon::parse($d->created_at)->format('d/m/Y H:i:s') }}
                                        </h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>
                                            @if ($d->fecha_fin != null)
                                                {{ \Carbon\Carbon::parse($d->fecha_fin)->format('d/m/Y H:i:s') }}
                                            @endif
                                        </h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $d->name }}</h6>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <td class="text-right">
                                <a href="javascript:void(0)" class="btn btn-dark" wire:click.prevent="finalizar()">DAR
                                    DE BAJA AL USUARIO</a>
                            </td>
                            @if ($usuarioACTIVO == 'NO')
                                <td class="text-left">
                                    <a href="javascript:void(0)" class="btn btn-dark"
                                        wire:click.prevent="Activar()">PONER
                                        ACTIVO AL USUARIO</a>
                                </td>
                            @endif
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
