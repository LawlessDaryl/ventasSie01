<div>
    <div class="row layout-top-spacing">
        <div class="col-sm-12" >
            <div class="widget widget-chart-one">
                <div class="widget-heading">
                    <div class="col-9 col-xl-6 col-lg-12 mb-xl-5 mb-5 ">
                        <div>
                            <h5 class="mb-2 mt-2">Detalle Compra COD: {{$nro_compra}}</h5>
                        </div>
                        <div class="d-flex b-skills">
                            <div class="infobox border border-dark rounded pl-2 pr-5">
                                <b class="info-text">Proveedor: </b> 
                       
                            NO DEFINIDO 
                             <br/>
                        
                                <b class="info-text">Fecha: </b><br/>
                              
                                <b class="info-text">Registrado por: </b> <br/>
                               
                              </div>
                        </div>

                    </div>
                    <ul class="tabs tab-pills">
                        <a href="javascript:void(0)" class="btn btn-dark m-2" data-toggle="modal"
                            data-target="#theModal">Agregar Proveedor</a>
                
                        <a href="javascript:void(0)" class="btn btn-dark m-2" data-toggle="modal"
                            data-target="#theModal">Crear Producto
                        </a>
                    </ul>
                </div>
                <div class="widget-content">
                    <div class="row">
                        <div class="col-5">
                                <div class="widget">
                                    <div class="col-lg-12 col-12 col-md-4 col-sm-12">
                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text input-gp">
                                                    <i class="fas fa-search"></i>
                                                </span>
                                            </div>
                                            <input type="text" wire:model="search" placeholder="Buscar" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-12 col-md-4 col-sm-12">
                                        <h6 class="border border-success rounded">
                                            <b>Elementos encontrados:</b> 0 Elementos encontrados
                                        </h6>
                                    </div>
                                </div>
                            
                            
                        </div>
                   
                        <div class="col-6">
                            <div class="widget">
                                <div class="col-lg-12 col-12 col-md-4 col-sm-12">

                                </div>
                            </div>
                        </div>

                </div>

            </div>
        </div>

    </div>
</div>
