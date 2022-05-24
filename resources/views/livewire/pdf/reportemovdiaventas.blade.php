<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movimiento Diario</title>
</head>
<body>
    <table class="estilostable" style="color: rgb(0, 0, 0)">
        <thead>
          <tr class="tablehead">
            <th class="text-center">N°</th>
            <th>FECHA</th>
            <th>USUARIO</th>
            <th>CARTERA</th>
            <th>CAJA</th>
            <th>MOVIMIENTO</th>
            <th class="text-right">IMPORTE</th>
            <th class="text-center">MOTIVO</th>
            <th class="text-right">UTILIDAD</th>
            <th class="text-center">SUCURSAL</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($value as $item)
                <tr class="seleccionar">
                    <td class="text-center">
                        {{$loop->iteration}}
                    </td>
                    <td>
                        {{ $item[0]->fecha }}
                    </td>
                    <td>
                        {{ ucwords($item->nombreusuario) }}
                    </td>
                    <td>
                        {{ ucwords(strtolower($item->nombrecartera)) }}
                    </td>
                    <td>
                        {{ ucwords($item->nombrecaja) }}
                    </td>
                    @if($item->tipo == "INGRESO")
                    <td style="color: rgb(8, 157, 212)">
                        <b>{{ $item->tipo }}</b>
                    </td>
                    @else
                    <td style="color: rgb(205, 21, 0)">
                        <b>{{ $item->tipo}}</b>
                    </td>
                    @endif
                    <td class="text-right">
                        {{ ucwords($item->importe) }} Bs
                    </td>
                    <td class="text-center">
                        {{ ucwords($item->motivo) }}
                    </td>
                </tr>
                @endforeach
        </tbody>
    </table>
</body>
</html>