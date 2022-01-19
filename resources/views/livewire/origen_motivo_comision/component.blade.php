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
                        <select wire:model="tipo" class="form-control">
                            <option value="Elegir" selected>==Seleccione el tipo==</option>
                            <option>Propia</option>
                            <option>Cliente</option>
                            
                        </select>
                    </div>
                    <div class="form-group mr-5">
                        <select wire:model="origen" class="form-control">
                            <option value="Elegir" disabled>==Seleccione el Origen==</option>
                            @foreach($origenes as $origen)
                            <option value="{{$origen->id}}" selected>{{$origen->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    @if($motivos !="Elegir")
                    <div class="form-group mr-5">
                        <select wire:model="motivo" class="form-control">
                            <option value="Elegir" selected>==Seleccione el motivo==</option>
                            {{-- @foreach($motivos as  $key => $mot)
                            <option value="{{$key}}" selected>{{$mot}}</option>
                            @endforeach --}}
                            @foreach($motivos as  $mot)
                            <option value="{{$mot->id}}" selected>{{$mot->nombre_motivo}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    
                    
                    {{-- <button onclick="Revocar()" type="button" class="btn btn-dark mbmobile mr-5">Revocar todos</button> --}}
                </div>


                <div class="row mt-3">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-unbordered table-hover mt-2">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="table-th text-withe">NOMBRE COMISION</th>
                                        <th class="table-th text-withe text-center">MONTO AFECTADO</th>
                                        <th class="table-th text-withe text-center">M INICIAL</th>
                                        <th class="table-th text-withe text-center">M FINAL</th>
                                        <th class="table-th text-withe text-center">COMISION</th>
                                        <th class="table-th text-withe text-center">PORCENTAJE</th>
                                </thead>
                                <tbody>
                                    @foreach ($comisiones as $comi)
                                    <tr>
                                        <td >
                                            <div class="n-chk">
                                            <label class="new-control new-checkbox checkbox-primary">
                                                <input type="checkbox" 
                                                wire:change="SyncPermiso($('#p' + {{ $comi->id 
                                                    }}).is(':checked'), '{{$comi->id}}')"
                                                    id="p{{ $comi->id }}"
                                                    value="{{ $comi->id }}"
                                                class="new-control-input" 
                                                {{ $comi->checked == 1 ? 'checked' : '' }}
                                                >
                                                <span class="new-control-indicator"></span>
                                                <h6>{{ $comi->nombre}}</h6>
                                            </label>

                                            </div>
                                        </td>
                                        
                                        <td>
                                            <h6 class="text-center">{{$comi->monto_a}}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{$comi->monto_inicial}}</h6>
                                        </td>
                                        <td>
                                            <h6 class="text-center">{{$comi->monto_final}}</h6>
                                        </td>
                                        
                                        <td>
                                            <h6 class="text-center">{{$comi->comision}}</h6>
                                        </td>
                                        <td class="text-center">
                                      
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" style="{{$comi->porcentaje == 'Activo' ? 'color: #29a727':'color: #f50707'}}" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-toggle-{{$comi->porcentaje == 'Activo' ? 'right':'left'}}"><rect x="1" y="5" width="22" height="14" rx="7" ry="7"></rect><circle cx="{{$comi->porcentaje == 'Activo' ? '16':'8'}}" cy="12" r="3"></circle></svg>
    
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $comisiones->links() }}
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
        window.livewire.on('no_sincronizar', Msg => {
            noty(Msg)
        });
    });

    /* function Revocar() {

        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Confirmas revocar todos las comisiones?',
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
    } */
</script>