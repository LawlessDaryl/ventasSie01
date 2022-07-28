<?php


namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Caja;


class HomeController extends Component
{

    public function render()
    {
        $data = Caja::join('sucursals as s', 's.id', 'cajas.sucursal_id')
            ->join('sucursal_users as su', 'su.sucursal_id', 's.id')
            ->join('carteras as car', 'cajas.id', 'car.caja_id')
            ->join('cartera_movs as cartmovs', 'car.id', 'cartmovs.cartera_id')
            ->join('movimientos as mov', 'mov.id', 'cartmovs.movimiento_id')
            ->where('mov.user_id', Auth()->user()->id)
            ->where('mov.status', 'ACTIVO')
            ->where('mov.type', 'APERTURA')
            ->select('cajas.*', 's.name as sucursal')
            ->get()->take(1);
         
        if ($data->count()==0) {
            session(['sesionCaja' => null]);
        } else{
            session(['sesionCaja' => $data[0]->nombre]);
        }
       
      
        return view('livewire.caja');
    }
}


