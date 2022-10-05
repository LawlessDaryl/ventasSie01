<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{$componentName}} | {{$pageTitle}}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-warning" data-toggle="modal"
                    data-target="#theModal">Agregar</a>
                </ul>
            </div>

            @include('common.searchbox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-bordered-bd-warning striped mt-1" >
                        <thead class="text-white" style="background: #ee761c">
                            <tr>
                               <th class="table-th text-white">EMPLEADO</th>
                               <th class="table-th text-white text-center">CONTRATO</th>
                               <th class="table-th text-withe text-center">ADELANTO</th>
                               <th class="table-th text-white text-center">NUEVO SALARIO</th>
                               <th class="table-th text-withe text-center">FECHA</th>
                               <th class="table-th text-withe text-center">MOTIVO</th>
                               <th class="table-th text-white text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($anticipos as $a)
                            <tr>
                                <td><h6>{{$a->empleado}}</h6></td>
                                <td><h6 class="text-center">{{$a->salario}}</h6></td>
                                <td><h6 class="text-center">{{$a->anticipo}} Bs</h6></td>

                                <td><h6 class="text-center">
                                    @if($a->descuento > 0)
                                        {{number_format($a->salario - ($a->anticipo +  $a->descuento))}} Bs
                                    @else
                                        {{number_format($a->salario - $a->anticipo)}}
                                    @endif
                                </h6></td>

                                <td><h6 class="text-center">{{\Carbon\Carbon::parse($a->created_at)->format('Y-m-d') }}</h6></td> {{-- {{$a->created_at}}{{ $employee->created_at->diffForHumans() }}--}}
                                <td><h6 class="text-center">{{$a->motivo}}</h6></td>

                                <td class="text-center">
                                    <a href="javascript:void(0)"
                                    wire:click="Edit({{$a->idAnticipo}})"
                                    class="btn btn-dark mtmobile" title="Edit">
                                    <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="javascript:void(0)"
                                        onclick="Confirm({{$a->idAnticipo}},'{{$a->verificar}}')"
                                        class="btn btn-dark mtmobile" title="Destroy">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$anticipos->links()}}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.anticipos.form')
</div>

@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function(){
        // Eventos
        window.livewire.on('asist-added', msg=>{
            $('#theModal').modal('hide')
        });
        window.livewire.on('asist-updated', msg=>{
            $('#theModal').modal('hide')
        });
        window.livewire.on('asist-deleted', msg=>{
            // mostrar notificacion de que el producto se a eliminado
        });
        window.livewire.on('show-modal', msg=>{
            $('#theModal').modal('show')
        });
        window.livewire.on('modal-hide', msg=>{
            $('#theModal').modal('hide')
        });
        window.livewire.on('hidden.bs.modal', msg=>{
            $('.er').css('display','none')
        });
    });

    function Confirm(id, verificar){
        if(verificar == 'si')
        {
            swal({
                title: 'CONFIRMAR',
                text: '¿CONFIRMAS ELIMINAR EL REGISTRO',
                type: 'WARNING',
                showCancelButton: true,
                cancelButtonText: 'cerrar',
                cancelButtonColor: '#fff',
                confirmButtonColor: '#3b3f5c',
                confirmButtonText: 'Aceptar'
            }).then(function(result){
                if(result.value){
                    window.livewire.emit('deleteRow',id)
                    swal.close()
                }
            })
        }
        else
        {
            swal('no es posible eliminar porque tiene datos relacionados')
            return;
        }
        
    }
</script>
<!-- Scripts para el mensaje de confirmacion arriba a la derecha Categoría Creada con Éxito y Alerta de Eliminacion -->
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- Fin Scripts -->
@endsection