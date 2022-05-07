<div wire:ignore.self id="modal-details" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <b>PERFILES DE ESTA CUENTA</b>
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
                                <th class="table-th text-center text-white">NOMBRE PERFIL</th>
                                <th class="table-th text-center text-white">PIN</th>
                                <th class="table-th text-center text-white">DISPONIBILIDAD</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($perfiles as $d)
                                <tr>
                                    <td class="text-center">
                                        <h6>{{ $d->namep }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $d->PIN }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6>{{ $d->availability }}</h6>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
