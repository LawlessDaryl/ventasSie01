<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\Movimiento;
use App\Models\RoleHasPermissions;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\User;
use Exception;

class SaleListController extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $componentName, $idventa, $usuarioseleccionado;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->listadetalles = [];
        $this->componentName = 'Lista de Ventas';
        //$this->listarventas();
        $this->listardetalleventas();
        $this->idventa = 1;
        $this->usuarioseleccionado = Auth()->user()->id;

    }


    public function render()
    {


        if($this->usuarioseleccionado > 1)
        {
            $data = Sale::join('users as u', 'u.id', 'sales.user_id')
            ->join("movimientos as m", "m.id", "sales.movimiento_id")
            ->join("cliente_movs as cm", "cm.movimiento_id", "m.id")
            ->join("clientes as c", "c.id", "cm.cliente_id")
            ->select('sales.id as id','sales.cash as totalbs','sales.created_at as fecha','sales.observacion as obs',
            'sales.tipopago as tipopago','sales.change as cambio','sales.factura as factura','sales.status as status',
            'u.name as user','c.razon_social as rz','c.cedula as ci','c.celular as celular')
            ->where('u.id', $this->usuarioseleccionado)
            ->orderBy('sales.id', 'desc')
            ->paginate(5);
        }
        else
        {
            $data = Sale::join('users as u', 'u.id', 'sales.user_id')
            ->join("movimientos as m", "m.id", "sales.movimiento_id")
            ->join("cliente_movs as cm", "cm.movimiento_id", "m.id")
            ->join("clientes as c", "c.id", "cm.cliente_id")
            ->select('sales.id as id','sales.cash as totalbs','sales.created_at as fecha','sales.observacion as obs',
            'sales.tipopago as tipopago','sales.change as cambio','sales.factura as factura','sales.status as status',
            'u.name as user','c.razon_social as rz','c.cedula as ci','c.celular as celular')
            ->orderBy('sales.id', 'desc')
            ->paginate(5);
        }

        //Listando Todos los Usuarios
        $listausuarios = User::select("users.id as id","users.name as nombreusuario")
        ->get();


        return view('livewire.sales.salelist', [
            'data' => $data,
            'listausuarios' => $listausuarios,
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }
    //Listar todas las ventas de un usuario
    public function listarventas()
    {
        $this->data = Sale::join('users as u', 'u.id', 'sales.user_id')
        ->join("movimientos as m", "m.id", "sales.movimiento_id")
        ->join("cliente_movs as cm", "cm.movimiento_id", "m.id")
        ->join("clientes as c", "c.id", "cm.cliente_id")
        ->select('sales.id as id','sales.cash as totalbs','sales.created_at as fecha',
        'sales.tipopago as tipopago','sales.change as cambio',
        'u.name as user','c.razon_social as rz','c.cedula as ci','c.celular as celular')
        ->where('u.id',Auth()->user()->id)
        ->orderBy('sales.id', 'desc')
        ->paginate(10);
    }
    //Listar los detalles de una venta
    public function listardetalleventas()
    {
        $this->listadetalles = SaleDetail::join('sales as s', 's.id', 'sale_details.sale_id')
        ->join("products as p", "p.id", "sale_details.product_id")
        ->select('p.image as image','p.nombre as nombre','p.precio_venta as po',
        'sale_details.price as pv','sale_details.quantity as cantidad')
        ->where('sale_details.sale_id', $this->idventa)
        ->orderBy('sale_details.id', 'asc')
        ->get();
        //dd($this->listadetalles);
    }
    //Cambiar el id de $this->idventa para mostrar detalles de esa venta en una Ventana Modal
    public function cambiaridventa($id)
    {
        $this->idventa = $id;
        $this->listardetalleventas();
        $this->emit('show-modal', 'show modal!');
    }
    //Obtener el total descuento de una venta
    public function totaldescuento($idventa)
    {
        $descuento = SaleDetail::join('sales as s', 's.id', 'sale_details.sale_id')
        ->join("products as p", "p.id", "sale_details.product_id")
        ->select('p.image as image','p.nombre as nombre','p.precio_venta as po',
        'sale_details.price as pv','sale_details.quantity as cantidad')
        ->where('sale_details.sale_id', $idventa)
        ->orderBy('sale_details.id', 'asc')
        ->get();

        $totaldescuento = 0;
        foreach($descuento as $d)
        {
            $totaldescuento = (($d->po - $d->pv)*$d->cantidad) + $totaldescuento;
        }
        return $totaldescuento;
    }
    //Obtener el total items de una venta
    public function totalitems()
    {
        $total = SaleDetail::join('sales as s', 's.id', 'sale_details.sale_id')
        ->join("products as p", "p.id", "sale_details.product_id")
        ->select('p.image as image','p.nombre as nombre','p.precio_venta as po',
        'sale_details.price as pv','sale_details.quantity as cantidad')
        ->where('sale_details.sale_id', $this->idventa)
        ->orderBy('sale_details.id', 'asc')
        ->get();

        $totalcantidad = 0;
        foreach($total as $d)
        {
            $totalcantidad = $d->cantidad + $totalcantidad;
        }
        return $totalcantidad;
    }
    //Obtener el total Bs de una venta
    public function totabs()
    {
        $venta = Sale::join('users as u', 'u.id', 'sales.user_id')
        ->join("movimientos as m", "m.id", "sales.movimiento_id")
        ->join("cliente_movs as cm", "cm.movimiento_id", "m.id")
        ->join("clientes as c", "c.id", "cm.cliente_id")
        ->select('sales.id as id','sales.cash as totalbs','sales.created_at as fecha',
        'sales.tipopago as tipopago','sales.change as cambio',
        'u.name as user','c.razon_social as rz','c.cedula as ci','c.celular as celular')
        ->where('sales.id', $this->idventa)
        ->get();

        $totalbs = 0;
        foreach($venta as $d)
        {
            $totalbs = $d->totalbs - $d->cambio;
        }
        return $totalbs;
    }
    //Metodo para Anular una Venta
    public function mostraranularmodal($idventa)
    {
        $this->idventa = $idventa;
        $this->listardetalleventas();

        $this->emit('show-anular', 'show modal!');
    }
    //Metodo para Verificar si el usuario tiene el Permiso para vender
    public function verificarpermiso()
    {
        if(Auth::user()->hasPermissionTo('VentasListaMasFiltros_Index'))
        {
            return true;
        }
        return false;
    }
    //Obtener tipo de pago de una Venta para Anular una Venta
    public function obtenertipopago()
    {

        try
        {
            $venta = Sale::find($this->idventa);
            return $venta->tipopago;
        }
        catch (Exception $e)
        {
            
        }



        
    }
    //Anular una Venta
    public function anularventa()
    {


        // Creando Movimiento
        $Movimiento = Movimiento::create([
            'type' => "ANULARVENTA",
            'import' => $this->totabs(),
            'user_id' => Auth()->user()->id,
        ]);


        /* Caja en la cual se encuentra el usuario */
        $cajausuario = Caja::join('sucursals as s', 's.id', 'cajas.sucursal_id')
        ->join('sucursal_users as su', 'su.sucursal_id', 's.id')
        ->join('carteras as car', 'cajas.id', 'car.caja_id')
        ->join('cartera_movs as cartmovs', 'car.id', 'cartmovs.cartera_id')
        ->join('movimientos as mov', 'mov.id', 'cartmovs.movimiento_id')
        ->where('mov.user_id', Auth()->user()->id)
        ->where('mov.status', 'ACTIVO')
        ->where('mov.type', 'APERTURA')
        ->select('cajas.id as id')
        ->get()->first();



        if ($this->obtenertipopago() == 'EFECTIVO')
        {
            //Tipo de Pago en la Venta
            $cartera = Cartera::where('tipo', 'cajafisica')
            ->where('caja_id', $cajausuario->id)->get()->first();
        }
        else
        {
            //Tipo de Pago en la Venta
            $cartera = Cartera::where('tipo', $this->obtenertipopago())
            ->where('caja_id', $cajausuario->id)->get()->first();
        }

        



        // Creando Cartera Movimiento
        CarteraMov::create([
            'type' => "EGRESO",
            'comentario' => "Por Venta Anulada",
            'cartera_id' => $cartera->id,
            'movimiento_id' => $Movimiento->id,
        ]);



        //Devolviento los productos a la tienda
        //Actualizando variable $listadetalles
        $this->listardetalleventas();


        $anular = Sale::find($this->idventa);
        $anular->update([
            'status' => 'CANCELED',
        ]);
        $anular->save();
        //dd('asd');
        $this->emit('show-anularcerrar', 'show modal!');
    }

    
}