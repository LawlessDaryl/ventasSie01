<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-warning" wire:click="nuevatransaccion()">+
                        Nueva</a>

                </ul>
            </div>
            @include('common.searchbox')

            <div>
                <h6 class="card-title">
                    <b>SALDO DE TUS CARTERAS:</b> <br>
                    @foreach ($carterasCaja as $item)
                        <b>{{ $item->nombre }}:</b>
                        <b>${{ $item->monto }}.</b>
                        <br>
                    @endforeach
                </h6>
            </div>

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="text-white" style="background: #ee761c">
                            <tr>
                                <th class="table-th text-withe text-center">HORA</th>
                                <th class="table-th text-withe text-center">CÉDULA</th>
                                <th class="table-th text-withe text-center">CONTACTO</th>
                                <th class="table-th text-withe text-center">CODIGO/TELEFONO</th>
                                <th class="table-th text-withe text-center">ORIGEN</th>
                                <th class="table-th text-withe text-center">MOTIVO</th>
                                <th class="table-th text-withe text-center">MONTO</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $d)
                                <tr
                                    style="{{ $d->estado == 'Anulada' ? 'background-color: #d97171 !important' : '' }}">
                                    <td class="text-center">
                                        <h6 class="text-center">
                                            <strong>{{ \Carbon\Carbon::parse($d->hora)->format('H:i') }}</strong>
                                        </h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center"><strong>{{ $d->codCliente }}</strong></h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center"><strong>{{ $d->TelCliente }}</strong></h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center"><strong>{{ $d->codigotrans }}</strong></h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center"><strong>{{ $d->origen_nombre }}</strong></h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center"><strong>{{ $d->motivo_nombre }}</strong></h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center"><strong>{{ $d->importe }}</strong></h6>
                                    </td>
                                    <td class="text-center">
                                        @can('Anular_trans_tigomoney_Boton')
                                            @if ($d->estado != 'Anulada')
                                                <a href="javascript:void(0)" onclick="Confirm({{ $d->id }})"
                                                    class="btn btn-warning" title="Anular">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            @endif
                                        @endcan
                                        <a href="javascript:void(0)" wire:click="VerObservaciones({{ $d->id }})"
                                            class="btn btn-dark mtmobile" title="Observaciones">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-align-center">
                                                <line x1="18" y1="10" x2="6" y2="10"></line>
                                                <line x1="21" y1="6" x2="3" y2="6"></line>
                                                <line x1="21" y1="14" x2="3" y2="14"></line>
                                                <line x1="18" y1="18" x2="6" y2="18"></line>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.transaccion.form')
    @include('livewire.transaccion.modalObservaciones')
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
        window.livewire.on('item-actualizado', Msg => {
            $('#Modal_Observaciones').modal('hide')
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
        window.livewire.on('show-modal3', Msg => {
            $('#Modal_Observaciones').modal('show')
        })
        window.livewire.on('g-i/e', Msg => {
            $('#modal-detailes').modal('hide')
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
