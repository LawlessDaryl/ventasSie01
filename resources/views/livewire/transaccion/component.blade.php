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
                    <a wire:click.prevent="viewDetails()" class="btn btn-dark">
                        Generar Ingreso/Egreso
                    </a>
                </ul>
            </div>
            @include('common.searchbox')

            <div class="n-chk">
                <label class="new-control new-radio radio-classic-primary">
                  <input type="radio" class="new-control-input" name="custom-radio-2" id="SI" value="SI" wire:change="ComisionSi()">
                  <span class="new-control-indicator"></span>SI
                </label>
                <label class="new-control new-radio radio-classic-primary">
                  <input type="radio" class="new-control-input" name="custom-radio-2" id="NO" value="NO" wire:change="ComisionNo()">
                  <span class="new-control-indicator"></span>NO
                </label>
            </div>

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
                    <table class="table table-unbordered table-striped mt-2">
                        <thead class="text-white" style="background: #3B3F5C">
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
                                            {{ \Carbon\Carbon::parse($d->hora)->format('H:i:s') }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $d->codCliente }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $d->TelCliente }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $d->codigotrans }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $d->origen_nombre }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $d->motivo_nombre }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $d->importe }}</h6>
                                    </td>
                                    <td class="text-center">
                                        @if ($d->estado != 'Anulada')
                                            <a href="javascript:void(0)" onclick="Confirm({{ $d->id }})"
                                                class="btn btn-dark mtmobile" title="Anular">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        @endif
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
    @include('livewire.transaccion.modalDetails')
    @include('livewire.transaccion.form')
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
