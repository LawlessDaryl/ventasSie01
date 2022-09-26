<table>
    <thead>
        <tr>
        
                                  
            <th>PRODUCTO</th>                              
            <th>CODIGO</th>                              
            <th>STOCK</th>
            <th>CANT.MIN</th>                                       
          
    </thead>
    <tbody>
        @foreach ($destinos_almacen as $destino)
       <tr>
              
                <td>
                   {{$destino->nombre}}
                   
                 
                </td>
                <td>
                    {{$destino->codigo}}
                </td>
              
           
                <td>
                    {{ $destino->stock_s }} 
                </td>
                <td>
                   {{ $destino->cantidad_minima }}
                </td>
          
            

            </tr>
        @endforeach
    </tbody>
</table>