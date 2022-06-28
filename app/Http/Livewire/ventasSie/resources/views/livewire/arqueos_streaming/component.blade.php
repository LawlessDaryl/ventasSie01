<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title text-center"><b>Arqueos Streaming</b></h4>
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

                    <div class="col-sm-12 col-md-2">
                        <label>Perfiles / Cuentas</label>
                        <div class="form-group">
                            <select wire:model="condicional" class="form-control">
                                <option value="0">Perfiles</option>
                                <option value="1">Cuentas</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <label>Fecha inicial</label>
                            <input type="date" wire:model.lazy="fromDate" class="form-control">
                            @error('fromDate')
                            <span class="text-danger">{{ $message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <label>Fecha final</label>
                            <input type="date" wire:model.lazy="toDate" class="form-control">
                            @error('toDate')
                            <span class="text-danger">{{ $message}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-3 mbmobile mt-2">
                        <div class="connect-sorting bg-dark">
                            <h5 class="text-white">Transacciones totales : <br> ${{number_format($total,2)}}</h5>
                        </div>
                    </div>
                    
                </div>
            </div>

            <div class="row mt-4">
                
                @if($condicional==0)
                
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mt-1">
                            <thead class="text-white" style="background: #3b3ff5;">
                                <tr>
                                    <th class="table-th text-withe text-center">PLATAFORMA</th>
                                    <th class="table-th text-withe text-center">CLIENTE</th>
                                    <th class="table-th text-withe text-center">CELULAR</th>
                                    <th class="table-th text-withe text-center">CORREO</th>
                                    <th class="table-th text-withe text-center">CONTRASEÑA CUENTA</th>
                                    <th class="table-th text-withe text-center">VENCIMIENTO CUENTA</th>
                                    <th class="table-th text-withe text-center">NOMBRE PERFIL</th>
                                    <th class="table-th text-withe text-center">PIN</th>
                                    <th class="table-th text-withe text-center">IMPORTE</th>
                                    <th class="table-th text-withe text-center">PLAN INICIO</th>
                                    <th class="table-th text-withe text-center">PLAN FIN</th> 
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
                                
                                @foreach($data as $p)
                                <tr>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $p->plataforma }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $p->cliente }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $p->celular }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $p->correo }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $p->password_account }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $p->accexp }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $p->nameprofile }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $p->pin }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $p->importe }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">
                                            {{ \Carbon\Carbon::parse($p->planinicio)->format('d:m:Y') }} </h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">
                                            {{ \Carbon\Carbon::parse($p->planfin)->format('d:m:Y') }} </h6>
                                    </td>
                                    <td class="text-center">
                                        <button wire:click.prevent="viewDetails({{$p->id}})" class="btn btn-warning btn-sm">
                                            <i class="fas fa-list"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                
                
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped mt-1">
                            <thead class="text-white" style="background: #3b3ff5;">
                                <tr>
                                    <th class="table-th text-withe text-center">PLATAFORMA</th>
                                    <th class="table-th text-withe text-center">CLIENTE</th>
                                    <th class="table-th text-withe text-center">CELULAR</th>
                                    <th class="table-th text-withe text-center">CORREO</th>
                                    <th class="table-th text-withe text-center">CONTRASEÑA CUENTA</th>
                                    <th class="table-th text-withe text-center">VENCIMIENTO CUENTA</th>
                                    <th class="table-th text-withe text-center">IMPORTE</th>
                                    <th class="table-th text-withe text-center">PLAN INICIO</th>
                                    <th class="table-th text-withe text-center">PLAN FIN</th> 
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
                                
                                @foreach($data as $p)
                                <tr>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $p->plataforma }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $p->cliente }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $p->celular }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $p->correo }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $p->password_account }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $p->accexp }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $p->importe }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">
                                            {{ \Carbon\Carbon::parse($p->planinicio)->format('d:m:Y') }} </h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">
                                            {{ \Carbon\Carbon::parse($p->planfin)->format('d:m:Y') }} </h6>
                                    </td>
                                    <td class="text-center">
                                        <button wire:click.prevent="viewDetails({{$p->id}})" class="btn btn-warning btn-sm">
                                            <i class="fas fa-list"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>                
                @endif
            </div>
        </div>
    </div>

    {{-- @include('livewire.arqueos_tigo.modalDetails') --}}
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('show-modal', Msg => {
            $('#modal-details').modal('show')
        })
    })
</script>