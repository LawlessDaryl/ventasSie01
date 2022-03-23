<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-dark" wire:click="Agregar()" data-target="#theModal">+
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
                        <table class="table table-unbordered table-hover mt-2">
                            <thead class="text-white" style="background: #3B3F5C">
                                <tr>
                                    <th class="table-th text-withe text-center">PLATAFORMA</th>
                                    <th class="table-th text-withe text-center">CLIENTE</th>
                                    <th class="table-th text-withe text-center">CORREO</th>
                                    <th class="table-th text-withe text-center">CONTRASEÑA CUENTA</th>
                                    <th class="table-th text-withe text-center">VENCIMIENTO CUENTA</th>
                                    <th class="table-th text-withe text-center">PERFIL</th>
                                    <th class="table-th text-withe text-center">IMPORTE</th>
                                    <th class="table-th text-withe text-center">PLAN INICIO</th>
                                    <th class="table-th text-withe text-center">PLAN FIN</th>
                                    <th class="table-th text-withe text-center">ACCIONES</th>
                                    <th class="table-th text-withe text-center">REALIZADO</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($planes as $p)
                                    <tr>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->plataforma }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->cliente }} {{ $p->celular }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->correo }} {{ $p->passCorreo }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->password_account }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->accexp }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->nameprofile }} {{ $p->pin }}</h6>
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
                                            <a href="javascript:void(0)"
                                                wire:click="VerObservaciones({{ $p->id }})"
                                                class="btn btn-dark mtmobile" title="Observaciones">
                                                <i class="fa-solid fa-file-signature"></i>
                                            </a>
                                            @if ($p->estado != 'ANULADO')
                                                <a href="javascript:void(0)" onclick="Confirm({{ $p->id }})"
                                                    class="btn btn-dark mtmobile" title="Anular">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            @endif                                            
                                        </td>
                                        <td class="text-center"
                                            style="{{ $p->ready == 'NO' ? 'background-color: #d97171 !important' : 'background-color: #09ed3d !important' }}">
                                            @if ($p->ready == 'NO')
                                                <a href="javascript:void(0)" class="btn btn-dark"
                                                    onclick="ConfirmHecho('{{ $p->id }}')">
                                                    <i class="fa-regular fa-circle-exclamation"></i>
                                                </a>
                                            @else
                                                <h6 class="text-center"><strong>Hecho</strong></h6>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $planes->links() }}
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
                                    <th class="table-th text-withe text-center">CORREO</th>
                                    <th class="table-th text-withe text-center">CONTRASEÑA CUENTA</th>
                                    <th class="table-th text-withe text-center">VENCIMIENTO CUENTA</th>
                                    <th class="table-th text-withe text-center">IMPORTE</th>
                                    <th class="table-th text-withe text-center">PLAN INICIO</th>
                                    <th class="table-th text-withe text-center">PLAN FIN</th>
                                    <th class="table-th text-withe text-center">ACCIONES</th>
                                    <th class="table-th text-withe text-center">REALIZADO</th>
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
                                            <h6 class="text-center">{{ $p->cliente }} {{ $p->celular }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-center">{{ $p->correo }} {{ $p->passCorreo }}</h6>
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
                                            <a href="javascript:void(0)"
                                                wire:click="VerObservaciones({{ $p->id }})"
                                                class="btn btn-dark mtmobile" title="Observaciones">
                                                <i class="fa-solid fa-file-signature"></i>
                                            </a>
                                            @if ($p->estado != 'ANULADO')
                                                <a href="javascript:void(0)" onclick="Confirm({{ $p->id }})"
                                                    class="btn btn-dark mtmobile" title="Anular">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            @endif                                     
                                        </td>
                                        <td class="text-center"
                                            style="{{ $p->ready == 'NO' ? 'background-color: #d97171 !important' : 'background-color: #09ed3d !important' }}">
                                            @if ($p->ready == 'NO')
                                                <a href="javascript:void(0)" class="btn btn-dark"
                                                    onclick="ConfirmHecho('{{ $p->id }}')">
                                                    <i class="fa-regular fa-circle-exclamation"></i>
                                                </a>
                                            @else
                                                <h6 class="text-center"><strong>Hecho</strong></h6>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $planes->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    @include('livewire.planes.form')
    @include('livewire.planes.modalObservaciones')
    @include('livewire.planes.modalPerfil')
    @include('livewire.planes.modalCrearPerfil')
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
        
        window.livewire.on('show-modalPerf', Msg => {
            $('#Modal_perfil').modal('show')
        })
        window.livewire.on('perf-actualizado', Msg => {
            $('#Modal_perfil').modal('hide')
            noty(Msg)
        })

        window.livewire.on('show-crearPerfil', Msg => {
            $('#Modal_crear_perfil').modal('show')
        })
        window.livewire.on('crearperfil-cerrar', Msg => {
            $('#Modal_crear_perfil').modal('hide')
            noty(Msg)
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

    function ConfirmHecho(id) {
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: '¿Ya realizó las acciones correspondientes y desea ponerlo en realizado?',
            showCancelButton: true,
            cancelButtonText: 'Cerrar',
            cancelButtonColor: '#383838',
            confirmButtonColor: '#3B3F5C',
            confirmButtonText: 'Aceptar'
        }).then(function(result) {
            if (result.value) {
                window.livewire.emit('Realizado', id)
                swal.fire(
                    'Se cambió a realizado'
                )
            }
        })
    }

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
