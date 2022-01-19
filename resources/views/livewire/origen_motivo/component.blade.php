<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }}</b>
                </h4>

            </div>

            <div class="widget-content">
                <div class="form-inline">
                    <div class="form-group mr-5">
                        <select wire:model="origen" class="form-control">
                            <option value="Elegir" selected>==Seleccione el Origen==</option>
                            @foreach($origenes as $origen)
                            <option value="{{$origen->id}}" selected>{{$origen->nombre}}</option>
                            @endforeach
                        </select>
                    </div>

                    <button wire:click.prevent="SyncAll()" type="button" class="btn btn-dark mbmobile inblock mr-5">Sincronizar todos</button>
                    <button onclick="Revocar()" type="button" class="btn btn-dark mbmobile mr-5">Revocar todos</button>
                </div>


                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-unbordered table-hover mt-2">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="table-th text-withe text-center">ID</th>
                                        <th class="table-th text-withe text-center">MOTIVOS</th>
                                        
                                </thead>
                                <tbody>
                                    @foreach ($motivos as $motivo)
                                    <tr>
                                        <td>
                                            <h6 class="text-center">{{$motivo->id}}</h6>
                                        </td>
                                        <td class="text-center">
                                            <div class="n-chk">
                                            <label class="new-control new-checkbox checkbox-primary">
                                                <input type="checkbox" 
                                                wire:change="SyncPermiso($('#p' + {{ $motivo->id 
                                                    }}).is(':checked'), '{{$motivo->id}}')"
                                                    id="p{{ $motivo->id }}"
                                                    value="{{ $motivo->id }}"
                                                class="new-control-input" 
                                                {{ $motivo->checked == 1 ? 'checked' : '' }}
                                                >
                                                <span class="new-control-indicator"></span>
                                                <h6>{{ $motivo->nombre_motivo}}</h6>
                                            </label>
                                            </div>
                                        </td>

                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $motivos->links() }}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {


        window.livewire.on('sync-error', Msg => {
            noty(Msg)
        });
        window.livewire.on('permi', Msg => {
            noty(Msg)
        });
        window.livewire.on('syncall', Msg => {
            noty(Msg)
        });
        window.livewire.on('removeall', Msg => {
            noty(Msg)
        });
    });

    function Revocar() {

        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Confirmas revocar todos los motivos?',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('revokeall')
                Swal.close()
            }
        })
    }
</script>