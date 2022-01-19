<div wire:ignore.self id="modal-details" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>Historial Contratos</b>
                </h5>
                <button class="close" data-dismiss="modal" type="button" aria-label="Close">
                    <span class="text-white">&times;</span>
                </button>
            </div>

            <div class="modal-body">

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
                            @foreach ($contr as $d)
                                <tr style="{{$d->fecha_fin == '' ? 'background-color: lightgreen !important':''}}">
                                    <td class="text-center">
                                        <h6>{{ $d->created_at }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $d->fecha_fin }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $d->name }}</h6>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            <td class="text-right">
                                <h6 class="text-info"></h6>
                            </td>
                        </tfoot>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
