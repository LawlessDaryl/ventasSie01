@section('css')
<style>
    .tablainventarios {
        width: 100%;
    
        min-height: 140px;
    }
    .tablainventarios thead {
        background-color: #1572e8;
        color: white;
    }
    .tablainventarios th, td {
        border: 0.5px solid #1571e894;
        padding: 4px;
       
    }
    .tablainventarios th {
        text-align: center;
    }
    tr:hover {
        background-color: rgba(99, 216, 252, 0.336);
    }
.tablaservicios {
        width: 90%;
       
    }
    .tablaservicios thead {
        background-color: #0d4da0;
        color: white;
    }
    .tablaservicios th, td {
        border: 0.5px solid #1571e894;
        padding: 4px;
    }
    .tablaservicios tr:hover {
        background-color: rgba(175, 180, 250, 0.336);
    }
</style>

@endsection

<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                  <center> <b>Control Entrada y Salida de Productos</b></center> 
                </h4>
                <ul class="row justify-content-end">
                    <a href="javascript:void(0)" class="btn btn-outline-primary" data-toggle="modal" wire:click= 'resetui()'
                    data-target="#operacion">Registrar Operacion</a>
      
                     
                </ul>
               
            </div>

            <div class="widget-body">
                <div class="col-lg-3 mb-2">

                    <select wire:model="tipo_de_operacion" class="form-control">
                        <option value="Entrada">Entrada</option>
                        <option value="Salida">Salida</option>
                    </select>
                </div>
              

                <div class="row pl-2">
                    <div class="col-lg-12">
                        <div class="widget-content">
                            <div class="table-responsive">
                                <table class="tablainventarios">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>                                
                                            <th>Fecha de Registro</th>                                                
                                            <th>Ubicacion</th>                                
                                            <th>Tipo Operacion</th>
                                            <th>Observacion</th>
                                            <th>Usuario</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @foreach ($ingprod as $data2)
                                           <tr>
                                                <td>
                                                    
                                                    <h6>{{ ($ingprod->currentpage()-1) * $ingprod->perpage() + $loop->index + 1 }}</h6>
                                                    
                                                </td>
                                                <td> <center>

                                                    {{\Carbon\Carbon::parse($data2->created_at)->format('d-m-Y')}}
                                                    <br>
                                                    {{\Carbon\Carbon::parse($data2->created_at)->format('h:i:s a')}}
                                                </center>
                                                </td>
                                             
                                                <td>
                                                   Sucursal {{$data2->destinos->sucursals->name}}
                                                    {{$data2->destinos->nombre}}
                                                  
                                                </td>
                                                <td>
                                                    {{$data2->concepto}}
                                                </td>
                                                <td>
                                                    {{$data2->observacion}}
                                                </td>
                                                <td>
                                                    {{$data2->usuarios->name}}
                                                </td>
                                                <td>
                                                    <center>
                                                    <button wire:click="ver({{ $data2->id }})" type="button" class="btn btn-secondary p-1" style="background-color: rgb(12, 100, 194)">
                                                       
                                                        <i class="fas fa-list"></i>
                                                    </button>
                                                    <button wire:click="verifySale({{ $data2->id }})" type="button" class="btn btn-danger p-1" style="background-color: rgb(12, 100, 194)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </center>
                                                  </td>

                                           </tr>
                                       @endforeach
                                    </tbody>
                                </table>
                                {{ $ingprod->links() }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @include('livewire.entradas_salidas.operacion')

   </div>


   @section('javascript')

   <script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('product-added', msg => {
            $('#operacion').modal('hide')
            
        });
        window.livewire.on('show-detail', msg => {
            $('#buscarproducto').modal('show')
            
        });

        window.livewire.on('venta', event => {
            swal(
                '¡No se puede eliminar el registro!',
                'Uno o varios de los productos de este registro ya fueron distribuidos y/o tiene relacion con varios registros del sistema.',
                'error'
                )
        });
  
        window.livewire.on('confirmar', event => {
         
            Swal.fire({
                title: 'Estas seguro de eliminar este registro?',
                text: "Esta accion es irreversible",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
            if (result.value) {
            
                window.livewire.emit('eliminar_registro');
                Swal.fire(
                'Eliminado!',
                 'El registro fue eliminado con exito',
                'success'
                 )
             }
            })
				
            });
        window.livewire.on('confirmarAll', event => {
         
            Swal.fire({
                title: 'Estas seguro de eliminar este registro?',
                text: "Esta accion es irreversible",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
            if (result.value) {
            
                window.livewire.emit('eliminar_registro_total');
                Swal.fire(
                'Eliminado!',
                 'El registro fue eliminado con exito',
                'success'
                 )
             }
            })
				
            });
            window.livewire.on('stock-insuficiente', event => {
        
        const toast = swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2500,
            padding: '2em'
            });
            toast({
                type: 'error',
                title: 'Stock insuficiente para la salida del producto en esta ubicacion.',
                padding: '2em',
            })
     });
  
    })
    </script>
        <script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
    @endsection
    