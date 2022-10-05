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
                               <th class="table-th text-white">NOMBRE</th>
                               <th class="table-th text-white text-center">DESCRIPCION</th>
                               <th class="table-th text-withe text-center">AREA</th>
                               <th class="table-th text-white text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($functionarea as $func)
                            <tr>
                                <td><h6>{{$func->name}}</h6></td>
                                <td><h6 class="text-center">{{$func->description}}</h6></td>
                                <td><h6 class="text-center">{{ $func->area }}</h6></td>

                                <td class="text-center">
                                    <a href="javascript:void(0)"
                                    wire:click="Edit({{$func->id}})"
                                    class="btn btn-dark mtmobile" title="Edit">
                                    <i class="fas fa-edit"></i>
                                    </a>

                                    <a href="javascript:void(0)"
                                        onclick="Confirm({{$func->id}},'{{$func->verificar}}')"
                                        class="btn btn-dark mtmobile" title="Destroy">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$functionarea->links()}}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.functionArea.form')
    @include('livewire.functionArea.nuevArea')
</div>

@section('javascript')
<script>
    document.addEventListener('DOMContentLoaded', function(){
        // Eventos crud
        window.livewire.on('fun-added', msg=>{
            $('#theModal').modal('hide')
        });
        window.livewire.on('fun-updated', msg=>{
            $('#theModal').modal('hide')
        });
        window.livewire.on('fun-deleted', msg=>{
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

        // formulario de Nueva Area
        window.livewire.on('show-modal-area', Msg => {
            $('#theModal-area').modal('show')
        })
        window.livewire.on('modal-hide-area', Msg => {
            $('#theModal-area').modal('hide')
        }) 
    });

    function Confirm(id, verificar){
        if(verificar == 'si')
        {
            swal({
                title: 'CONFIRMAR',
                text: '¿CONFIRMAS ELIMINAR  EL REGISTRO',
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
