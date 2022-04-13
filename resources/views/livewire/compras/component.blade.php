
<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>Compras</b>
                </h4>
                <ul class="tabs tab-pills">
                    
                        <a href="detalle_compras" class="btn btn-dark" >Registrar<br/>Compra</a>
                      
                    
                </ul>
            </div>
              
                
            
            <div class="widget-body">

                <div class="row m-1" >
                    <div class="col-12 col-lg-5 col-md-4 card">
                        <h5 class="mt-2">Fecha de Compra</h5>
                        <div class="row mt-1">
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
                        </div>
                    </div>
                    <div class="col-12 col-lg-5 col-md-4 card ml-3">
                        <h5 class="mt-2">Filtrado</h5>
                        <div class="row mt-1">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Seleccionar filtro</label>
                                    <select wire:model="filtro" class="form-control">
                                        <option value="0" disabled>Elegir</option>
                                      
                                            <option value='id'>Numero de Compra</option>
                                            <option value='tipo_doc'>Numero de Factura</option>
                                            <option value='proveedor_id'>Nombre Proveedor</option>
                                       
                                    </select>
                                    @error('filtro')
                                    <span class="text-danger">{{ $message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                               
                               
                               
                                <div class="form-group">
                                    <label>Ingresar criterio</label>
                                    <input type="text" wire:model.lazy="criterio" class="form-control">
                                    @error('criterio')
                                    <span class="text-danger">{{ $message}}</span>
                                    @enderror
                                </div>
                               
                               
                              
                            </div>
                        </div>
                    </div>
                </div>

    {{--tabla que muestra todas las compras--}}

                <div class="row">
                    <div class="col-lg-12">
                        <div class="widget-content">
                            <div class="table-responsive">
                                <table class="table table-unbordered table-hover mt-2">
                                    <thead class="text-white" style="background: #3B3F5C">
                                        <tr>
                                           
                                            <th class="table-th text-withe text-center">#</th>                                
                                            <th class="table-th text-withe text-center">Proveedor</th>                                
                                            <th class="table-th text-withe text-center">Documento</th>                                
                                            <th class="table-th text-withe text-center">Total<br>Compra</br></th>                                
                                            <th class="table-th text-withe text-center">Tipo<br>Compra</br> </th>                                
                                            <th class="table-th text-withe text-center">Saldo</th>                                
                                                                         
                                            <th class="table-th text-withe text-center">Estado</th>
                                            <th class="table-th text-withe text-center">Usuario</th>
                                            <th class="table-th text-withe text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_compras as $data)
                                            <tr>
                                               

                                            
                                                <td>
                                                    <h6 class="text-center">{{ $nro++}}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="text-center">{{ $data->nombre_prov}}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="text-left">{{$data->tipo_doc}}</h6>
                                                    <h6 class="text-center">{{ $data->nro_documento }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="text-center">{{ $data->importe_total }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="text-center">{{ $data->transaccion }}</h6>
                                                </td>
                                                <td>
                                                    <h6 class="text-center">{{ $data->saldo_por_pagar }}</h6>
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
                                                    <a href="javascript:void(0)" wire:click="Edit({{ $data->id }})"
                                                        class="btn btn-dark mtmobile" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" onclick="Confirm('{{ $data->id }}')" 
                                                        class="btn btn-dark" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" onclick="Confirm('{{ $data->id }}')" 
                                                        class="btn btn-dark" title="Delete">
                                                        <i class="fas fa-info"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tfoot class="text-white text-right" style="background: #fffefd"  >
                                            <tr>
                                                <td colspan="8">
                                                     <h5 class="text-dark">Total.-</h5>
                                                </td>
                                                <td>
                                                    <h5 class="text-dark">{{$totales}}</h5>
                                                </td>
                                            </tr>
                                            
                                    </tfoot>
                                    </tbody>
                                </table>
                           
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
   </div>