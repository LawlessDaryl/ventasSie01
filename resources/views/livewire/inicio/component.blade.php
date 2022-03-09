{{--<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <b>{{ $componentName }} | {{ $pageTitle }}</b>
                </h4>
                <ul class="tabs tab-pills">
                    <a href="javascript:void(0)" class="btn btn-dark" wire:click="GoService">Agregar</a>
                </ul>
            </div>

            
            <div class="row justify-content-between">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="input-group mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text input-gp">
                                <i class="fas fa-search"></i>
                            </span>
                        </div>
                        <input type="text" wire:model="search" placeholder="Buscar" class="form-control">
                  
                    </div>
                    
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <select wire:model.lazy="opciones" class="form-control">
                            <option value="TODOS" >TODOS</option>
                            <option value="PENDIENTE" >PENDIENTE</option>
                            <option value="PROCESO" >PROCESO</option>
                            <option value="TERMINADO" >TERMINADO</option>
                            <option value="ENTREGADO" >ENTREGADO</option>
                    </select>
                    @error('opciones') <span class="text-danger er">{{ $message }}</span>@enderror
                </div>
            </div>


            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-unbordered table-striped mt-2">
                        <thead class="text-white" style="background: #3B3F5C">
                            <tr>
                                <th class="table-th text-withe text-center" width="2%">#</th>
                                <th class="table-th text-withe text-center" width="60%"> 
                             
                                    <div class="col-sm-12 col-md-12">
                                    <div class="row">
                                       
                                        <div class="col-sm-1">CLIENTE</div>                                
                                        <div class="col-sm-2">FECHAS</div>
                                        <div class="col-sm-5">SERVICIOS</div>
                                        <div class="col-sm-4">ESTADO</div>
                                     </div>
                                     </div>
                                        </th>
                                <th class="table-th text-withe text-center" width="7%">CÓDIGO</th>
                                <th class="table-th text-withe text-center" width="7%">TOTAL</th>
                                <th class="table-th text-withe text-center" width="10%">A CUENTA</th>
                                <th class="table-th text-withe text-center" width="7%">SALDO</th>
                                <th class="table-th text-withe text-center" width="7%">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                @if($item->status == 'ACTIVO')
                                <tr>
                                    <td width="2%">
                                        <h6 class="table-th text-withe text-center">{{ $loop->iteration }}</h6>
                                    </td>
                                    @php
                                        $mytotal = 0;
                                        $myacuenta = 0;
                                        $mysaldo = 0;
                                    @endphp
                                    <td width="60%">
                                       
                                        @foreach ($item->services as $key => $service)
                                            @php
                                                $mytotal += $service->movservices[0]->movs->import;
                                                $myacuenta += $service->movservices[0]->movs->on_account;
                                                $mysaldo += $service ->movservices[0]->movs->saldo;
                                            @endphp
                                         <div class="col-sm-12 col-md-12">
                                         <div class="row">
                                  
                                        <div class="col-sm-1">
                                            @if ($key== 0)
                                                <h6 class="table-th text-withe text-center"><b>
                                                    {{ $service->movservices[0]->movs->climov->client->nombre }}</b></h6>
                                            @endif
                                        </div>
                                   
                                        <div class="col-sm-2">
                                            <h6 class="table-th text-withe text-center">{{ $service->fecha_estimada_entrega }}</h6><br/>
                                        </div>
                                      
                 
                                        <div class="col-sm-5">
                                            <a href="javascript:void(0)" wire:click="InfoService({{ $service->id }})"
                                                title="Ver Servicio"><h6>{{ $service->categoria->nombre }}&nbsp{{ $service->marca }}&nbsp | {{ $service->detalle }}&nbsp | {{ $service->falla_segun_cliente }}</h6></a>
                                            
                                            @foreach ($service->movservices as $mm)
                                            
                                            @if ($mm->movs->status == 'ACTIVO')
                                            <h6><b>Responsable:</b> {{ $mm->movs->usermov->name }}</h6>
                                        </div>

                                  
                                        <div class="col-sm-4">
                                       
                                           
                                                <div class="col-2 col-xl-6 col-lg-1 mb-xl-1 mb-1 ">
                                                    <h6 class="table-th text-withe text-center"><b>{{ $mm->movs->type }}</b></h6>
                                                    Serv: {{ $item->type_service }}
                                                </div>
                                                    @if($mm->movs->type == 'PENDIENTE')
                                                        <a href="javascript:void(0)" class="btn btn-dark mtmobile" wire:click="Edit({{ $service->id }})"
                                                            title="Cambiar Estado">{{ $mm->movs->type }}</a>
                                                    @endif

                                                    @if (!empty(session('sesionCaja')))
                                                    @if($mm->movs->type == 'TERMINADO')
                                                    <a href="javascript:void(0)" class="btn btn-dark mtmobile" wire:click="DetallesTerminado({{ $service->id }})"
                                                        title="Cambiar Estado">Entregar</a>
                                                    @endif
                                                    @endif

                                                    @if($mm->movs->type != 'ENTREGADO')
                                                    <a href="javascript:void(0)" class="btn btn-dark mtmobile" wire:click="Detalles({{ $service->id }})"
                                                        title="Cambiar Estado">Detalle</a>
                                                    @endif

                                                    @if($mm->movs->type == 'ENTREGADO')
                                                        <a href="javascript:void(0)" class="btn btn-dark mtmobile" wire:click="DetalleEntregado({{ $service->id }})"
                                                            title="Ver Detalle">Detalle Entregado</a>
                                                    @endif

                                                    @if (count($item->services) - 1 != $key)
                                                            <br />
                                                    @endif
                                                
                                                @endif
                                                
                                            
                                            @endforeach
                                        </div>
                                        
                                    </div> 
                                    @if (count($item->services) - 1 != $key)
                                        <hr
                                            style="border-color: black; margin-top: 0px; margin-bottom: 3px; margin-left: 5px; margin-right:5px">
                                        <br />
                                    @endif
                                </div>
                                        @endforeach
                                    </td>

                                    <td class="text-center" width="7%">
                                        <h6 class="table-th text-withe text-center">{{ $item->id }}</h6>
                                    </td>

                                    <td class="text-center" width="7%">
                                        <h6 class="text-info">
                                            {{ number_format($mytotal, 2) }} Bs.
                                        </h6>
                                    </td>

                                    <td class="text-center" width="10%">
                                        <h6 class="text-info">
                                            {{ number_format($myacuenta, 2) }} Bs.
                                        </h6>
                                    </td>

                                    <td class="text-center" width="7%">
                                        <h6 class="text-info">
                                            {{ number_format($mysaldo, 2) }} Bs.
                                        </h6>
                                    </td>

                                    <td class="text-center" width="7%">
                                        <a href="javascript:void(0)" class="btn btn-dark mtmobile" wire:click="VerOpciones({{$item->id}})"
                                            title="Opciones">Opciones</a>
                                    </td>

                                </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.order_service.form')
    @include('livewire.order_service.formdetalle')
    @include('livewire.order_service.formdetalleentrega')
    @include('livewire.order_service.forminfoservicio')
    @include('livewire.order_service.formopciones')
    @include('livewire.order_service.formentregado')
    @include('livewire.order_service.formeliminar')
    @include('livewire.order_service.formanular')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {


        window.livewire.on('product-added', msg => {
            $('#theModal').modal('hide'),
                noty(msg)
        });
        window.livewire.on('product-updated', msg => {
            $('#theModal').modal('hide')
            noty(msg)
        });
        window.livewire.on('product-deleted', msg => {
            noty(msg)
        });
        window.livewire.on('show-modal', Msg => {
            $('#theModal').modal('show')
        });
        window.livewire.on('modal-hide', msg => {
            $('#theModal').modal('hide')
        });

        window.livewire.on('show-detail', Msg => {
            $('#theDetail').modal('show')
        });
        window.livewire.on('detail-hide', msg => {
            $('#theDetail').modal('hide')
        });
        window.livewire.on('detail-hide-msg', msg => {
            $('#theDetail').modal('hide')
            noty(msg)
        });

        window.livewire.on('show-detalle-entrega', Msg => {
            $('#theDetalleEntrega').modal('show')
        });
        window.livewire.on('hide-detalle-entrega', msg => {
            $('#theDetalleEntrega').modal('hide')
        });
        window.livewire.on('hide-detalle-entrega-msg', msg => {
            $('#theDetalleEntrega').modal('hide')
            noty(msg)
        });

        window.livewire.on('show-infserv', Msg => {
            $('#theInfoService').modal('show')
        });
        window.livewire.on('hide-infserv', msg => {
            $('#theInfoService').modal('hide')
        });
        window.livewire.on('hide-infserv-msg', msg => {
            $('#theInfoService').modal('hide')
            noty(msg)
        });

        window.livewire.on('show-options', Msg => {
            $('#theOptions').modal('show')
        });
        window.livewire.on('hide-options', msg => {
            $('#theOptions').modal('hide')
        });
        window.livewire.on('hide-options-msg', msg => {
            $('#theOptions').modal('hide')
            noty(msg)
        });

        window.livewire.on('show-enddetail', Msg => {
            $('#theEndDetail').modal('show')
        });
        window.livewire.on('hide-enddetail', msg => {
            $('#theEndDetail').modal('hide')
        });
        window.livewire.on('hide-enddetail-msg', msg => {
            $('#theEndDetail').modal('hide')
            noty(msg)
        });

        window.livewire.on('show-deletemodal', Msg => {
            $('#theDeleteModal').modal('show')
        });
        window.livewire.on('hide-deletemodal', msg => {
            $('#theDeleteModal').modal('hide')
        });
        window.livewire.on('hide-deletemodal-msg', msg => {
            $('#theDeleteModal').modal('hide')
            noty(msg)
        });

        window.livewire.on('show-modalanular', Msg => {
            $('#ModalAnular').modal('show')
        });
        window.livewire.on('hide-modalanular', msg => {
            $('#ModalAnular').modal('hide')
        });
        window.livewire.on('hide-modalanular-msg', msg => {
            $('#ModalAnular').modal('hide')
            noty(msg)
        });

        window.livewire.on('hidden.bs.modal', function(e) {
            $('.er').css('display', 'none')
        });
    });

    function Confirm(id, name, products) {
        if (products > 0) {
            swal.fire({
                title: 'PRECAUCION',
                icon: 'warning',
                text: 'No se puede eliminar el producto, ' + name + ' porque tiene ' +
                    products + ' ventas relacionadas'
            })
            return;
        }
        swal.fire({
            title: 'CONFIRMAR',
            icon: 'warning',
            text: 'Confirmar eliminar el prouducto ' + '"' + name + '"',
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

    function ChangeStates()
    {
        
    }

</script>
--}}


<div class="widget-content widget-content-area">
    <div class="table-responsive mb-4">
        <div id="style-3_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_length" id="style-3_length">
                        <label>Results :  
                            <select name="style-3_length" aria-controls="style-3" class="form-control">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                            </select>
                        </label>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div id="style-3_filter" class="dataTables_filter">
                        <label><svg xmlns="http://www.w3.org/2000/svg" width="24" 
                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                            class="feather feather-search">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="search" class="form-control" placeholder="Search..." 
                            aria-controls="style-3">
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <table id="style-3" class="table style-3 table-hover dataTable no-footer" 
                    role="grid" aria-describedby="style-3_info">
            <thead>
                <tr role="row">
                    <th class="text-center" tabindex="0" 
                    aria-controls="style-3" rowspan="1" colspan="1"  
                    style="width: 130.016px;font-size:18px" > Record Id </th>
                    <th class="text-center" 
                    tabindex="0" aria-controls="style-3" rowspan="1" colspan="1" 
                    aria-label="Image: activate to sort column ascending" style="width: 80.4375px;font-size:18px">Image</th>
                    <th class="" tabindex="0" aria-controls="style-3" rowspan="1" colspan="1" 
                    style="width: 140.422px;font-size:18px">First Name</th>
                    <th class="" tabindex="0" aria-controls="style-3" rowspan="1" colspan="1" 
                    style="width: 132.891px;font-size:18px">Last Name</th>
                    <th class="" tabindex="0" aria-controls="style-3" rowspan="1" colspan="1" 
                    style="width: 199.594px;font-size:18px">Email</th>
                    <th class="" tabindex="0" aria-controls="style-3" rowspan="1" colspan="1" 
                    style="width: 138.047px;font-size:18px">Mobile No.</th>
                    <th class="text-center" tabindex="0" aria-controls="style-3" rowspan="1" 
                    colspan="1" style="width: 111.188px;font-size:18px">Status</th>
                    <th class="text-center" tabindex="0" aria-controls="style-3" rowspan="1" 
                    colspan="1" style="width: 94.4062px;font-size:18px">Action</th>
                </tr>
            </thead>
            <tbody> 
            <tr role="row">
                    <td class="checkbox-column text-center sorting_1"><h4> 1 </h4></td>
                    <td class="text-center">
                        <span><img src="assets/img/90x90.jpg" class="profile-img" alt="avatar"></span>
                    </td>
                    <td><h4>Donna</h4></td>
                    <td><h4>Rogers</h4></td>
                    <td><h4>donna@yahoo.com</h4></td>
                    <td><h4>555-555-5555</h4></td>
                    <td class="text-center"><span class="shadow-none badge badge-primary"><h4>Approved</h4></span></td>
                    <td class="text-center">
                        <ul class="table-controls">
                            <li>
                                <a href="javascript:void(0);" class="bs-tooltip" data-toggle="tooltip" 
                                    data-placement="top" title="" data-original-title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                                        stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="bs-tooltip" data-toggle="tooltip" 
                                data-placement="top" title="" data-original-title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                                stroke-linejoin="round" class="feather feather-trash p-1 br-6 mb-1">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
                <tr role="row">
                    <td class="checkbox-column text-center sorting_1"> 2 </td>
                    <td class="text-center">
                        <span>
                            <img src="assets/img/90x90.jpg" class="profile-img" alt="avatar">
                        </span>
                    </td>
                    <td>Andy</td>
                    <td>King</td>
                    <td>andyking@gmail.com</td>
                    <td>555-555-6666</td>
                    <td class="text-center">
                        <span class="shadow-none badge badge-warning">Suspended</span>
                    </td>
                    <td class="text-center">
                        <ul class="table-controls">
                            <li>
                                <a href="javascript:void(0);" class="bs-tooltip" data-toggle="tooltip" 
                                data-placement="top" title="" data-original-title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                                stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="bs-tooltip" data-toggle="tooltip" 
                                data-placement="top" title="" data-original-title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                                stroke-linejoin="round" class="feather feather-trash p-1 br-6 mb-1">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr><tr role="row">
                    <td class="checkbox-column text-center sorting_1"> 3 </td>
                    <td class="text-center">
                        <span><img src="assets/img/90x90.jpg" class="profile-img" alt="avatar"></span>
                    </td>
                    <td>Alma</td>
                    <td>Clarke</td>
                    <td>Alma@live.com</td>
                    <td>777-555-5555</td>
                    <td class="text-center"><span class="shadow-none badge badge-danger">Closed</span></td>
                    <td class="text-center">
                        <ul class="table-controls">
                            <li>
                                <a href="javascript:void(0);" class="bs-tooltip" data-toggle="tooltip" 
                                data-placement="top" title="" data-original-title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                                stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="bs-tooltip" data-toggle="tooltip" 
                                data-placement="top" title="" data-original-title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                                stroke-linejoin="round" class="feather feather-trash p-1 br-6 mb-1">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr><tr role="row">
                    <td class="checkbox-column text-center sorting_1"> 4 </td>
                    <td class="text-center">
                        <span><img src="assets/img/90x90.jpg" class="profile-img" alt="avatar"></span>
                    </td>
                    <td>Vincent</td>
                    <td>Carpenter</td>
                    <td>vinnyc@outlook.com</td>
                    <td>555-666-5555</td>
                    <td class="text-center"><span class="shadow-none badge badge-primary">Approved</span></td>
                    <td class="text-center">
                        <ul class="table-controls">
                            <li>
                                <a href="javascript:void(0);" class="bs-tooltip" data-toggle="tooltip" 
                                data-placement="top" title="" data-original-title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                                stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="bs-tooltip" data-toggle="tooltip" 
                                data-placement="top" title="" data-original-title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                                stroke-linejoin="round" class="feather feather-trash p-1 br-6 mb-1">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr><tr role="row">
                    <td class="checkbox-column text-center sorting_1"> 5 </td>
                    <td class="text-center">
                        <span><img src="assets/img/90x90.jpg" class="profile-img" alt="avatar"></span>
                    </td>
                    <td>Kristen</td>
                    <td>Beck</td>
                    <td>kristen@adobe.com</td>
                    <td>444-444-4444</td>
                    <td class="text-center">
                        <span class="shadow-none badge badge-warning">Suspended</span>
                    </td>
                    <td class="text-center">
                        <ul class="table-controls">
                            <li>
                                <a href="javascript:void(0);" class="bs-tooltip" data-toggle="tooltip" 
                                data-placement="top" title="" data-original-title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                                stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                </svg>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="bs-tooltip" data-toggle="tooltip" 
                                data-placement="top" title="" data-original-title="Delete">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                                stroke-linejoin="round" class="feather feather-trash p-1 br-6 mb-1">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                </svg>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-5">
        <div class="dataTables_info" id="style-3_info" role="status" 
            aria-live="polite">Showing page 1 of 2
        </div>
    </div>
    <div class="col-sm-12 col-md-7">
        <div class="dataTables_paginate paging_simple_numbers" id="style-3_paginate">
            <ul class="pagination">
                <li class="paginate_button page-item previous disabled" id="style-3_previous">
                    <a href="#" aria-controls="style-3" data-dt-idx="0" tabindex="0" class="page-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                        stroke-linejoin="round" class="feather feather-arrow-left">
                        <line x1="19" y1="12" x2="5" y2="12"></line>
                        <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                    </a>
                </li>
                <li class="paginate_button page-item active">
                    <a href="#" aria-controls="style-3" data-dt-idx="1" tabindex="0" class="page-link">1</a>
                </li>
                <li class="paginate_button page-item ">
                    <a href="#" aria-controls="style-3" data-dt-idx="2" tabindex="0" class="page-link">2</a>
                </li>
                <li class="paginate_button page-item next" id="style-3_next">
                    <a href="#" aria-controls="style-3" data-dt-idx="3" tabindex="0" class="page-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" 
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                        stroke-linejoin="round" class="feather feather-arrow-right">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
</div>
</div>
</div>
