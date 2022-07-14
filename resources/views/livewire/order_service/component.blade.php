


<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">

                
         
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-head-bg-primary table-hover" style="min-width: 1000px;">
                        <thead class="text-white" style="background: #ee761c">
                            <tr>
                                <th class="text-withe text-center">#</th>
                                <th class="text-withe text-center">Código</th>
                                <th class="text-withe text-center">Fecha Creación</th>
                                <th class="text-withe text-center">Servicio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orden_de_Servicio as $os)
                            <tr>
                                <td class="text-center">
                                    {{$os->num}}
                                </td>
                                <td class="text-center">
                                    {{$os->id}}
                                </td>
                                <td class="text-center">
                                    {{ \Carbon\Carbon::parse($os->fechacreacion)->format('d/m/Y h:i:s a') }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $orden_de_Servicio->links() }}
            </div>
        </div>
    </div>
</div>
