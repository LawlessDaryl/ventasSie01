<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal" data-target="#theModal">+
                        Nueva</a>
                </ul>
            </div>
            @include('common.searchbox')
            <div>

                <h6 class="card-title">
                    <b>SALDO DE TUS CARTERAS:</b> <br>
                    @foreach ($carterasCaja as $item)
                        <b>{{ $item->nombre }}: </b><b>{{ $item->monto }} Bs.</b>
                        <br>
                    @endforeach
                </h6>

                <div class="form-group">
                    <div class="row">
                        <div class="col-sm-12 col-md-2">
                            <div class="form-group">
                                <div class="n-chk">
                                    <label class="new-control new-radio radio-classic-primary">
                                        <input type="radio" class="new-control-input" name="custom-radio-4"
                                            id="perfiles" value="perfiles" wire:model="condicional" checked>
                                        <span class="new-control-indicator"></span>PERFILES
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2">
                            <div class="form-group">
                                <div class="n-chk">
                                    <label class="new-control new-radio radio-classic-primary">
                                        <input type="radio" class="new-control-input" name="custom-radio-4" id="cuentas"
                                            value="cuentas" wire:model="condicional">
                                        <span class="new-control-indicator"></span>CUENTAS
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            @if ($condicional == 'perfiles')
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-unbordered table-striped mt-2">
                            <thead class="text-white" style="background: #3B3F5C">
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
                                    <th class="table-th text-withe text-center">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($planes as $p)
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
                                            @if ($p->estado != 'ANULADO')
                                                <a href="javascript:void(0)" onclick="Confirm({{ $p->id }})"
                                                    class="btn btn-dark mtmobile" title="Anular">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            @endif
                                            <a href="javascript:void(0)"
                                                wire:click="VerObservaciones({{ $p->id }})"
                                                class="btn btn-dark mtmobile" title="Observaciones">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                                    id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512"
                                                    style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                    <circle style="fill:#88C5CC;" cx="256" cy="256" r="256" />
                                                    <path style="fill:#F5F5F5;"
                                                        d="M192,72h176c4.4,0,8,3.6,8,8v328c0,4.4-3.6,8-8,8H120c-4.4,0-8-3.6-8-8V156L192,72z" />
                                                    <path style="fill:#E6E6E6;"
                                                        d="M184,156c4.4,0,8-3.6,8-8V72l-80,84H184z" />
                                                    <circle style="fill:#2179A6;" cx="352" cy="392" r="52" />
                                                    <g>
                                                        <path style="fill:#F5F5F5;"
                                                            d="M352,424c-2.212,0-4-1.788-4-4v-56c0-2.212,1.788-4,4-4s4,1.788,4,4v56   C356,422.212,354.212,424,352,424z" />
                                                        <path style="fill:#F5F5F5;"
                                                            d="M380,396h-56c-2.212,0-4-1.788-4-4s1.788-4,4-4h56c2.212,0,4,1.788,4,4S382.212,396,380,396z" />
                                                    </g>
                                                </svg>
                                            </a>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- {{ $planes->links() }} --}}
                    </div>
                </div>
            @else
                <div class="widget-content">
                    <div class="table-responsive">
                        <table class="table table-unbordered table-striped mt-2">
                            <thead class="text-white" style="background: #3B3F5C">
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
                                    <th class="table-th text-withe text-center">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($planes as $p)
                                    <tr
                                        style="{{ $p->estado == 'ANULADO' ? 'background-color: #d97171 !important' : '' }}">
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
                                            @if ($p->estado != 'ANULADO')
                                                <a href="javascript:void(0)" onclick="Confirm({{ $p->id }})"
                                                    class="btn btn-dark mtmobile" title="Anular">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            @endif
                                            <a href="javascript:void(0)"
                                                wire:click="VerObservaciones({{ $p->id }})"
                                                class="btn btn-dark mtmobile" title="Observaciones">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                                    id="Layer_1" x="0px" y="0px" viewBox="0 0 512 512"
                                                    style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                                    <circle style="fill:#88C5CC;" cx="256" cy="256" r="256" />
                                                    <path style="fill:#F5F5F5;"
                                                        d="M192,72h176c4.4,0,8,3.6,8,8v328c0,4.4-3.6,8-8,8H120c-4.4,0-8-3.6-8-8V156L192,72z" />
                                                    <path style="fill:#E6E6E6;"
                                                        d="M184,156c4.4,0,8-3.6,8-8V72l-80,84H184z" />
                                                    <circle style="fill:#2179A6;" cx="352" cy="392" r="52" />
                                                    <g>
                                                        <path style="fill:#F5F5F5;"
                                                            d="M352,424c-2.212,0-4-1.788-4-4v-56c0-2.212,1.788-4,4-4s4,1.788,4,4v56   C356,422.212,354.212,424,352,424z" />
                                                        <path style="fill:#F5F5F5;"
                                                            d="M380,396h-56c-2.212,0-4-1.788-4-4s1.788-4,4-4h56c2.212,0,4,1.788,4,4S382.212,396,380,396z" />
                                                    </g>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- {{ $planes->links() }} --}}
                    </div>
                </div>
            @endif
        </div>
    </div>
    @include('livewire.planes.form')
    @include('livewire.planes.modalObservaciones')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('item-added', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('item-anulado', Msg => {
            noty(Msg)
        })
        window.livewire.on('item-error', Msg => {
            noty(Msg)
        })
        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        })
        window.livewire.on('hide-modal', Msg => {
            $('#theModal').modal('hide')
        })
        window.livewire.on('show-modal2', Msg => {
            $('#modal-detailes').modal('show')
        })
        window.livewire.on('g-i/e', Msg => {
            $('#modal-detailes').modal('hide')
            noty(Msg)
        })
        window.livewire.on('item-actualizado', Msg => {
            $('#Modal_Observaciones').modal('hide')
            noty(Msg)
        })
        window.livewire.on('show-modal3', Msg => {
            $('#Modal_Observaciones').modal('show')
        })
        flatpickr(document.getElementsByClassName('flatpickr'), {
            enableTime: false,
            dateFormat: 'Y-m-d',
            locale: {
                firstDayofweek: 1,
                weekdays: {
                    shorthand: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
                    longhand: [
                        "Domingo",
                        "Lunes",
                        "Martes",
                        "Miércoles",
                        "Jueves",
                        "Viernes",
                        "Sábado",
                    ],
                },
                months: {
                    shorthand: [
                        "Ene",
                        "Feb",
                        "Mar",
                        "Abr",
                        "May",
                        "Jun",
                        "Jul",
                        "Ago",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dic",
                    ],
                    longhand: [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre",
                    ],
                },
            }
        })

    });

    function Confirm(id) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Realmente desea Anular esta transacción?',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('deleteRow', id)
                Swal.close()
            }
        })
    }
</script>
