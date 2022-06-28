<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title text-center"><b>Arqueos Tigo Money</b></h4>
            </div>

            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <label for="">Usuario</label>
                            <select wire:model="userid" class="form-control">
                                <option value="0" disabled>Elegir</option>
                                @foreach($users as $u)
                                    <option value="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </select>
                            @error('userid')
                            <span class="text-danger">{{ $message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label>Fecha inicial</label>
                            <input type="date" wire:model.lazy="fromDate" class="form-control">
                            @error('fromDate')
                            <span class="text-danger">{{ $message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3">
                        <div class="form-group">
                            <label>Fecha final</label>
                            <input type="date" wire:model.lazy="toDate" class="form-control">
                            @error('toDate')
                            <span class="text-danger">{{ $message}}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <label>Origen</label>
                            <select wire:model="origenfiltro" class="form-control">
                                <option value="0" selected>Todas</option>
                                    <option value="Sistema">Sistema</option>
                                    <option value="Telefono">Telefono</option>                                
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <label for="">Tipo de transacción</label>
                            <select wire:model="tipotr" class="form-control">
                                <option value="0" selected>Todas</option>
                                    <option value="Retiro">Retiro</option>
                                    <option value="Abono">Abono</option> 
                            </select>
                            @error('tipotr')
                            <span class="text-danger">{{ $message}}</span>
                            @enderror
                        </div>
                    </div>
                    
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-sm-12 col-md-3 mbmobile">
                    <div class="form-control" style="background: #ee761c">
                        <h5 class="text-white">Transacciones Totales : <br> ${{number_format($total,2)}}</h5>
                    </div>
                </div>

                <div class="col-sm-12 col-md-9">
                    <div class="table-responsive">
                        <table class="table table-hover table table-bordered table-bordered-bd-warning mt-4">
                            <thead class="text-white" style="background: #ee761c">
                                <tr>
                                    <th class="table-th text-center text-white">CEDULA</th>
                                    <th class="table-th text-center text-white">TELEFONO</th>
                                    <th class="table-th text-center text-white">DESTINO</th>
                                    <th class="table-th text-center text-white">IMPORTE</th>
                                    <th class="table-th text-center text-white">ESTADO</th>
                                    <th class="table-th text-center text-white">ORIGEN</th>
                                    <th class="table-th text-center text-white">MOTIVO</th>
                                    <th class="table-th text-center text-white">FECHA</th>
                                    <th class="table-th text-center text-white">DETALLES</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if($total<=0)
                                <tr>
                                    <td colspan="9">
                                        <h6 class="text-center">No hay transacciones en la fecha seleccionada</h6>
                                    </td>
                                </tr>
                                @endif
                                
                                @foreach($transaccions as $row)
                                <tr style="{{$row->estado == 'Anulada' ? 'background-color: #d97171 !important':''}}">
                                    <td class="text-center"><h6>{{$row->cedula}}</h6></td>
                                    <td class="text-center"><h6>{{$row->telefono}}</h6></td>
                                    <td class="text-center"><h6>{{$row->codigo_transf}}</h6></td>
                                    <td class="text-center"><h6>{{number_format($row->importe,2)}}</h6></td>
                                    <td class="text-center"><h6>{{$row->estado}}</h6></td>
                                    <td class="text-center"><h6>{{$row->origen_nombre}}</h6></td>
                                    <td class="text-center"><h6>{{$row->motivo_nombre}}</h6></td>
                                    <td class="text-center"><h6>{{$row->created_at}}</h6></td>
                                    <td class="text-center">
                                        <button wire:click.prevent="viewDetails({{$row->id}})" class="btn btn-warning">
                                            <i class="fas fa-list"></i>
                                        </button>
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

    @include('livewire.arqueos_tigo.modalDetails')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('show-modal', Msg => {
            $('#modal-details').modal('show')
        })
    })
</script>