<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget">
            <div class="widget-heading">
                <h4 class="card-title text-center"><b>{{$componentName}}</b></h4>
            </div>

            <div class="widget-content">
                <div class="row">
                    <div class="col-sm-12 col-md-12">
                        <!-- TABLA -->
                        <div class="table-responsive">
                            <table class="table table-unbordered table-hover mt-1">
                                <thead class="text-white" style="background: #3B3F5C">
                                    <tr>
                                        <th class="table-th text-withe text-center">No</th>
                                        <th class="table-th text-withe text-right">TOTAL</th>
                                        <th class="table-th text-withe text-center">CANTIDAD</th>
                                        <th class="table-th text-withe text-center">ESTADO</th>
                                        <th class="table-th text-withe text-center">USUARIO</th>
                                        <th class="table-th text-withe text-center">CLIENTE</th>
                                        <th class="table-th text-withe text-center">FECHA</th>
                                        <th class="table-th text-withe text-center" width="50px"> Acciòn</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($data) < 1) <tr>
                                        <td colspan="7">
                                            <h5>Sin Resultados</h5>
                                        </td>
                                        </tr>
                                        @endif

                                        @foreach ($data as $d)
                                        <tr>
                                            <td class="table-th text-withe text-center">
                                                <h6>{{ $d->id }}</h6>
                                            </td>
                                            <td class="table-th text-withe text-right">
                                                <h6>{{number_format( $d->total, 2) }} Bs</h6>
                                            </td>
                                            <td class="table-th text-withe text-center">
                                                <h6>{{ $d->items }}</h6>
                                            </td>
                                            <td class="table-th text-withe text-center">
                                                @if($d->status == "PAID")
                                                <h6>PAGADO</h6>
                                                @else
                                                <h6>{{ $d->status }}</h6>
                                                @endif
                                            </td>
                                            <td class="table-th text-withe text-center">
                                                <h6>{{ $d->user }}</h6>
                                            </td>
                                            <td class="table-th text-withe text-center">
                                                <h6>{{ $d->movimiento_id }}</h6>
                                            </td>
                                            <td class="table-th text-withe text-center">
                                                <h6>
                                                    {{\Carbon\Carbon::parse($d->created_at)->format('d-m-Y')}}
                                                </h6>
                                            </td class="table-th text-withe text-center">
                                            <td class="text-center">
                                                <button wire:click.prevent="devolucionventa({{$d->id}})" class="btn btn-dark btn-sm">
                                                    Devoluciòn
                                                    {{-- <i class="fas fa-list"></i> --}}
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>