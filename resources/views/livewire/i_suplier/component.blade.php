<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    
                        <a href="javascript:void(0)" class="btn btn-warning" data-toggle="modal"
                        data-target="#theModal">Agregar Proveedor</a>
                    
                </ul>
            </div>
            @include('common.searchbox')

            <div class="row">
                <div class="col-12 col-lg-12 col-md-4 d-flex flex-lg-wrap flex-wrap flex-md-wrap flex-xl-wrap justify-content-left">
                    @foreach ($data_proveedor as $data)
                               
                            <div class="card component-card_4" style="width: 18rem; margin:2rem;">
                                
                                    <div class="user-info">
                                        <div class="card-header">

                                            <h5 class="card-user_name">{{$data->nombre_prov." ".$data->apellido}}</h5>
                                        </div>
                                      <div class="card-body" >

                                          <p class="card-text"> <strong>Telefono:</strong> {{$data->telefono ? $data->telefono : "No definido" }}</p>
                                          <p class="card-text"> <strong>Direccion:</strong> {{$data->direccion ? $data->direccion : "No definido" }}</p>
                                          <p class="card-text"> <strong>Correo:</strong> {{$data->correo ? $data->correo : "No definido" }}</p>
                                          <p class="card-text"> <strong>Status:</strong> {{$data->status}}</p>
                                          <a href="javascript:void(0)" wire:click="Edit({{ $data->id }})"
                                            class="btn btn-dark mtmobile" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" onclick="Confirm('{{ $data->id }}','{{ $data->nombre }}')" 
                                            class="btn btn-warning" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </a>

                                      </div>
                                    </div>
                                
                            
                                </div>
                            @endforeach
                    </div>
                            
                   
                    {{ $data_proveedor->links() }}
                </div>
            </div>
        </div>
        @include('livewire.i_suplier.form')
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('proveedor-added', msg => {
            $('#theModal').modal('hide')
        });
        window.livewire.on('proveedor-updated', msg => {
            $('#theModal').modal('hide')
        });
        window.livewire.on('proveedor-deleted', msg => {
            ///
        });
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show')
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
        });        
        $('theModal').on('hidden.bs.modal',function(e) {
            $('.er').css('display','none')
        })

    });

    function Confirm(id,nombre) {
     
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar la proveedor ' + '"' + nombre + '"',
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