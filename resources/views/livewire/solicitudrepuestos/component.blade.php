@section('css')
<style>
    /* Estilos para las tablas */
    .table-wrapper {
    width: 100%;/* Anchura de ejemplo */
    /*height: 750px;  Altura de ejemplo */
    /* overflow: auto; */
    }

    .table-wrapper table {
        border-collapse: separate;
        border-spacing: 0;
        border-left: 0.3px solid #007bff;
        border-bottom: 0.3px solid #007bff;
        width: 100%;
    }

    .table-wrapper table thead {
        position: -webkit-sticky; /* Safari... */
        position: sticky;
        top: 0;
        left: 0;
    }
    .table-wrapper table thead tr {
    background: #007bff;
    color: white;
    }
    /* .table-wrapper table tbody tr {
        border-top: 0.3px solid rgb(0, 0, 0);
    } */
    .table-wrapper table tbody tr:hover {
        background-color: #ffdf76a4;
    }
    .table-wrapper table td {
        border-top: 0.3px solid #007bff;
        padding-left: 10px;
        border-right: 0.3px solid #007bff;
    }
</style>
@endsection
<div class="row">
    <div class="col-12 text-center">
        <p class="h1">SOLICITUDES</p>
    </div>
    <div class="col-12">
        <div class="table-wrapper">
            <table class="text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Orden de Servicio</th>
                        <th>Tecnico Solicitante</th>
                        <th>Producto Solicitado</th>
                        <th>Cantidad Solicitada</th>
                        <th>Estado</th>
                        <th>Fecha Solicitud</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lista_solicitudes as $l)
                    <tr>
                        <td>
                            {{$loop->iteration}}
                        </td>
                        <td>
                            <span class="stamp stamp" style="background-color: #1572e8">
                                1256
                            </span>
                        </td>
                        <td>
                            Emanuel
                        </td>
                        <td>
                            Cable UTP
                        </td>
                        <td>
                            4
                        </td>
                        <td>
                            PENDIENTE DE APROBACION
                        </td>
                        <td>
                            @if($l->minutos >= 0)
                            <span class="stamp stamp" style="background-color: #4e00df">
                                Hace <b>{{$l->minutos}}</b> Minutos
                            </span>
                            <br>
                            @endif
                            {{$l->created_at}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
    </div>
</div>
