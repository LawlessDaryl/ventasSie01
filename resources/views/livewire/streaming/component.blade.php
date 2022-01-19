<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">                   
                        <a href="javascript:void(0)" class="btn btn-dark" data-toggle="modal"
                        data-target="#theModal">+ Nueva</a>                   
                </ul>
            </div>
            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-hover mt-2">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-withe text-center">HORA</th>
                                <th class="table-th text-withe">NOMBRE CLIENTE</th>
                                <th class="table-th text-withe">CI CLIENTE</th>                                
                                <th class="table-th text-withe text-center">ORIGEN</th>                              
                                <th class="table-th text-withe text-center">MOTIVO</th>
                                <th class="table-th text-withe text-center">MONTO</th>
                                <th class="table-th text-withe text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $d)
                                <tr>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ \Carbon\Carbon::parse($d->hora)->format('H:i:s') }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $d->nomClient }}</h6>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="text-center">{{ $d->codCliente }}</h6>
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
                                        <a href="javascript:void(0)" wire:click="Edit()"
                                            class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="javascript:void(0)" onclick="Confirm()" 
                                        class="btn btn-dark"
                                            title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>

                                        <a href="javascript:void(0)" onclick="" 
                                        class="btn btn-dark"
                                            title="Detalles">
                                            <i class="fas fa-list"></i>
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
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        
        window.livewire.on('item-added', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('item-updated', Msg => {
            $('#theModal').modal('hide')
            noty(Msg)
        })
        window.livewire.on('item-deleted', Msg => {
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
        window.livewire.on('user-withsales', Msg => {
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

        //eventos
        window.livewire.on('show-modal', msg => {
            $('#modalDetails').modal('show')
        });

    });

    function Confirm(id) {
        
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar el usuario ' + '"' + id + '"',
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

