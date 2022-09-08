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
    .tablainventarios th, td  {
        border: 0.5px solid #1571e894;
        padding: 4px;
       
    }
    .tablainventarios th {
        text-align: center;
    }
    tr:hover {
        background-color: rgba(99, 216, 252, 0.336);
    }

   .tablainventarios .tablainventarios .unidad label {
        text-align: center;
        color: aliceblue;
        border: #101216;
        border-radius: 5px;
        border-color: #1572e8;
    }
        

</style>
@endsection
    



<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>Compras</b>
                </h4>
                <ul class="row justify-content-end">
                        <a href="detalle_compras" class="btn btn-outline-primary" >Registrar Compra</a>
                        {{-- <a href="{{ url('reporteCompras/pdf' . '/' . $filtro . '/' . $fecha .'/'
                        . $from. '/' . $to . '/' .$search)}}" class="btn btn-warning m-1" >Imprimir</a> --}}
                </ul>
               
            </div>

            <div class="widget-body">

                <div class="row m-1">
                    <div class="col-12 col-lg-5 col-md-4 card">
                        <h5 class="mt-2">Fecha de Compra</h5>

                        <div class="row align-items-center mt-1">

                            <div class="col-lg-8">

                                <select wire:model="fecha" class="form-control">
                                        <option value='hoy' selected>Hoy</option>
                                        <option value='ayer'>Ayer</option>
                                        <option value='semana'>Semana</option>
                                        <option value='fechas'>Entre Fechas</option>
                                </select>
                            </div>
                            @if($fecha == 'fechas')
                        <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Fecha inicial</label>
                                    <input type="date" wire:model.lazy="fromDate" class="form-control">
                                    @error('fromDate')
                                    <span class="text-danger">{{ $message}}</span>
                                    @enderror
                                 </div>
                             </div>
                        <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Fecha final</label>
                                    <input type="date" wire:model.lazy="toDate" class="form-control">
                                    @error('toDate')
                                    <span class="text-danger">{{ $message}}</span>
                                    @enderror
                                </div>
                        </div>
                            @endif

                        </div>
                    </div>
                    <div class="col-12 col-lg-5 col-md-4 card ml-3">
                        <h5 class="mt-2">Filtrar Transaccion</h5>
                        <div class="row mt-1">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <select wire:model="filtro" class="form-control">
                                            <option value ='Contado' selected>Contado</option>
                                            <option value='Credito'>Credito</option>
                                    </select>
                                    @error('filtro')
                                    <span class="text-danger">{{ $message}}</span>
                                    @enderror
                                </div>
                            </div>
                          
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-12 mt-3">

                        @include('common.searchbox')
                    </div>
                </div>

    {{--tabla que muestra todas las compras--}}

                <div class="row">
                    <div class="col-lg-12">
                        <div class="widget-content">
                            <div class="table-responsive">
                                <table class="tablainventarios" >
                                    <thead>
                                        <tr>
                                           
                                            <th>#</th>                                
                                            <th>Fecha</th>                                
                                            <th>Proveedor</th>                                
                                            <th>Documento</th>                                
                                            <th>Tipo<br>Compra</br></th>                                
                                            <th>Total<br>Compra</br></th>                                
                                            <th>Saldo</th>                                
  
                                            <th>Estado</th>
                                            <th>Usuario</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_compras as $data)
                                            <tr>
                                                <td>
                                                    <h6>{{ $loop->index+1}}</h6>
                                                </td>
                                                <td>
                                                   
                                                    <center> {{\Carbon\Carbon::parse($data->created_at)->format('d-m-Y')}}
                                                        <br>
                                                        {{\Carbon\Carbon::parse($data->created_at)->format('h:i:s a')}}</center>
                                                </td>
                                                <td>
                                                    <h6 class="text-center" wire:key="{{ $loop->index }}">{{ $data->nombre_prov}}</h6>
                                                </td>
                                                <td>
                                                    <center><h6>{{$data->tipo_doc}}</h6>
                                                        <h6 class="text-center">{{ $data->nro_documento }}</h6></center>
                                                    
                                                </td>
                                                <td>
                                                    <h6 class="text-center">{{ $data->transaccion }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="text-center">{{ $data->importe_total }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="text-center">{{ $data->saldo }}</h6>
                                                </td>
                                              
                                                @if( $data->status_compra == 'ACTIVO')
                                                <td>
                                                    <h6 class="text-center card text-white bg-primary">{{ $data->status_compra }}</h6>
                                                </td>
                                                @else
                                                <td>
                                                    <h6 class="text-center card text-white bg-danger">{{ $data->status_compra }}</h6>
                                                </td>
                                                @endif
                                                <td>
                                                    <h6 class="text-center">{{ $data->name }}</h6>
                                                </td>
                                              
                                                
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" wire:click= "editarCompra('{{$data->id}}')"
                                                        class="btn btn-dark p-1" title="Editar compra">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ url('Compras/pdf' . '/' . $data->compra_id)}}"  
                                                        class="btn btn-success p-1" title="Imprimir detalle compra">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" wire:click="Destroy('{{ $data->id }}')" 
                                                        class="btn btn-danger p-1" title="Borrar compra">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                        <tfoot class="text-white text-right" style="background: #fffefd"  >
                                            <tr>
                                                <td colspan="4">
                                                     <h5 class="text-dark">Total Bs.-</h5>
                                                     <h5 class="text-dark">Total $us.-</h5>
                                                </td>
                                                <td>
                                                    <h5 class="text-dark text-center">{{$totales}}</h5>
                                                    <h5 class="text-dark text-center">{{round($totales/6.96,2)}}</h5>
                                                </td>
                                            </tr>
                                            
                                    </tfoot>
                                </table>
                          
                           
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
   </div>

   <script>
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('purchase-deleted', msg => {
            noty(msg)
        });
        window.livewire.on('purchase-error', msg => {
            noty(msg)
        });
     
    })
    </script>