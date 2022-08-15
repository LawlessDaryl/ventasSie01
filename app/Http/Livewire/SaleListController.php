<?php

namespace App\Http\Livewire;

use App\Models\Caja;
use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\Movimiento;
use App\Models\ProductosDestino;
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
use App\Models\Sucursal;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Exception;


class SaleListController extends Component
{
    use WithFileUploads;
    use WithPagination;

    //Guardar el id de una Venta
    public $idventa;

    //Cambiar Usuario Vendedor
    public $nombreusuariovendedor, $idventaeditar;

    //Buscador de Ventas por Código o Cliente
    public $search;

    //Id de Sucursal seleccionada
    public $sucursal_id;
    //Id del Usuario Seleccionado
    public $user_id;

    //Tipo de Fecha (Todas las Fechas, Hoy y Rango de Fechas)
    public $tipofecha;

    //Mostrar u Ocultar mas Filtros
    public $masfiltros;


    //Mostrar/Ocultar una Columna en la tabla principal con datos del Cliente
    public $mostrarcliente;

    //VARIABLES PARA GUARDAR VARIABLES PARA EDITAR INFORMACION

    //Editar una Venta
    public $venta_id;




    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->listadetalles = [];
        $this->mostrarcliente = 'No';
        $this->listardetalleventas();
        $this->idventa = 1;
        $this->user_id = Auth()->user()->id;

    }


    public function render()
    {

        if($this->user_id > 0)
        {
            $data = Sale::join('users as u', 'u.id', 'sales.user_id')
            ->join("movimientos as m", "m.id", "sales.movimiento_id")
            ->join("cliente_movs as cm", "cm.movimiento_id", "m.id")
            ->join("clientes as c", "c.id", "cm.cliente_id")
            ->join("carteras as carts", "carts.id", "sales.cartera_id")
            ->select('sales.id as id','sales.cash as totalbs', 'sales.total as totalbsventa', 'sales.created_at as fecha','sales.observacion as obs',
            'sales.tipopago as tipopago','sales.change as cambio','sales.factura as factura','sales.status as status','carts.nombre as cartera',
            'u.name as user','c.razon_social as rz','c.cedula as ci','c.celular as celular')
            ->where('u.id', $this->user_id)
            ->orderBy('sales.id', 'desc')
            ->paginate(50);
        }
        else
        {
            $data = Sale::join('users as u', 'u.id', 'sales.user_id')
            ->join("movimientos as m", "m.id", "sales.movimiento_id")
            ->join("cliente_movs as cm", "cm.movimiento_id", "m.id")
            ->join("clientes as c", "c.id", "cm.cliente_id")
            ->join("carteras as carts", "carts.id", "sales.cartera_id")
            ->select('sales.id as id','sales.cash as totalbs', 'sales.total as totalbsventa', 'sales.created_at as fecha','sales.observacion as obs',
            'sales.tipopago as tipopago','sales.change as cambio','sales.factura as factura','sales.status as status','carts.nombre as cartera',
            'u.name as user','c.razon_social as rz','c.cedula as ci','c.celular as celular')
            ->orderBy('sales.id', 'desc')
            ->paginate(50);
        }

        //Listando Todos los Usuarios
        $listausuarios = User::select("users.id as id","users.name as nombreusuario","users.profile as rol")
        ->get();

    
        return view('livewire.sales.salelist', [
            'data' => $data,
            'listasucursales' => Sucursal::all(),
            'listausuarios' => $this->listarusuarios(),
            'listausuarios' => $listausuarios
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }


    //Listar los Usuarios para ser asignados a un servicio Pendiente en una Ventana Modal
    public function listarusuarios()
    {
        $listausuarios = User::join('model_has_roles as mhr', 'mhr.model_id', 'users.id')
        ->join('roles as r', 'r.id', 'mhr.role_id')
        ->join('role_has_permissions as rhp', 'rhp.role_id', 'r.id')
        ->join('permissions as p', 'p.id', 'rhp.permission_id')
        ->select("users.id as idusuario","users.name as nombreusuario")
        ->where('p.name', 'Aparecer_Lista_Servicios')
        ->distinct()
        ->get();

        return $listausuarios;
    }


    //Listar todas las ventas de un usuario
    public function listarventas()
    {
        $this->data = Sale::join('users as u', 'u.id', 'sales.user_id')
        ->join("movimientos as m", "m.id", "sales.movimiento_id")
        ->join("cliente_movs as cm", "cm.movimiento_id", "m.id")
        ->join("clientes as c", "c.id", "cm.cliente_id")
        ->select('sales.id as id','sales.cash as totalbs', 'sales.total as totalbsventa','sales.created_at as fecha',
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
        ->select('p.id as idproducto','p.image as image','p.nombre as nombre','p.precio_venta as po',
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
            $totaldescuento = (($d->pv - $d->po)*$d->cantidad) + $totaldescuento;
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
        $venta = Sale::find($this->idventa);
        if($this->idventa != null)
        {
            return 0;
        }
        else
        {
            return $venta->total;
        }
    }
    //Obtener el total Bs de una venta
    public function observacion()
    {
        $venta = Sale::find($this->idventa);

        if($this->idventa != null)
        {
            return 0;
        }
        else
        {
            return $venta->observacion;
        }

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
        if(Auth::user()->hasPermissionTo('VentasListaMasFiltros'))
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

            $cartera = Cartera::find($venta->cartera_id);

            return $cartera->nombre. " - ".$cartera->descripcion;
        }
        catch (Exception $e)
        {
            
        }
        
    }
    //Anular una Venta
    public function anularventa()
    {
        //dd($this->idventa);
        // Creando Movimiento
        // $Movimiento = Movimiento::create([
        //     'type' => "ANULARVENTA",
        //     'import' => $this->totabs(),
        //     'user_id' => Auth()->user()->id,
        // ]);

        //Obteniendo Información de la Venta
        $venta = Sale::find($this->idventa);

        $movimiento = Movimiento::find($venta->movimiento_id);

        $movimiento->update([
            'status' => 'INACTIVO'
            ]);
        $movimiento->save();
        
        // Creando Cartera Movimiento
        // CarteraMov::create([
        //     'type' => "EGRESO",
        //     'comentario' => "Por Venta Anulada",
        //     'cartera_id' => $venta->cartera_id,
        //     'movimiento_id' => $Movimiento->id,
        // ]);

        //Actualizando variable $listadetalles
        $this->listardetalleventas();


        //Devolviento los productos a la tienda

        //Guardando en una variable los productos y sus cantidades de una venta para devolverlos a la Tienda
        $items = $this->listadetalles;
        foreach ($items as $item)
        {
            //Incrementando el stock en tienda
            $tiendaproducto = ProductosDestino::join("products as p", "p.id", "productos_destinos.product_id")
            ->join('destinos as des', 'des.id', 'productos_destinos.destino_id')
            ->select("productos_destinos.id as id","p.nombre as name",
            "productos_destinos.stock as stock")
            ->where("p.id", $item->idproducto)
            ->where("des.nombre", 'TIENDA')
            ->where("des.sucursal_id", $this->idsucursal())
            ->get()->first();


            $tiendaproducto->update([
                'stock' => $tiendaproducto->stock + $item->cantidad
            ]);
        }






        $anular = Sale::find($this->idventa);
        $anular->update([
            'status' => 'CANCELED',
        ]);
        $anular->save();
        //dd('asd');
        $this->emit('show-anularcerrar', 'show modal!');
    }
    //Obtener el Id de la Sucursal Donde esta el Usuario
    public function idsucursal()
    {
        $idsucursal = User::join("sucursal_users as su","su.user_id","users.id")
        ->select("su.sucursal_id as id","users.name as n")
        ->where("users.id",Auth()->user()->id)
        ->where("su.estado","ACTIVO")
        ->get()
        ->first();
        return $idsucursal->id;
    }

    //Crear Comprobante de Ventas
    public function crearcomprobante($idventa)
    {

        $this->idventa = $idventa;

        $totalbs = $this->totabspdf($idventa);
        //Llamar al Modal de Espera
        //$this->emit('modalespera');
        //Redireccionando para crear el comprobante con sus respectvas variables
        
        return redirect::to('report/pdf' . '/' . $totalbs. '/' . $this->idventa . '/' . $this->totalitems());
    }
    

    
    //Obtener el total Bs de una venta
    public function totabspdf($idventa)
    {
        $venta = Sale::join('users as u', 'u.id', 'sales.user_id')
        ->join("movimientos as m", "m.id", "sales.movimiento_id")
        ->join("cliente_movs as cm", "cm.movimiento_id", "m.id")
        ->join("clientes as c", "c.id", "cm.cliente_id")
        ->select('sales.id as id','sales.cash as totalbs', 'sales.total as totalbsventa','sales.created_at as fecha',
        'sales.tipopago as tipopago','sales.change as cambio',
        'u.name as user','c.razon_social as rz','c.cedula as ci','c.celular as celular')
        ->where('sales.id', $idventa)
        ->get();

        $totalbs = 0;
        foreach($venta as $d)
        {
            $totalbs = $d->totalbs - $d->cambio;
        }
        return $totalbs;
    }
    //Metodo para llamar a la venta modal para editar una Venta
    public function editsale($idventa)
    {
        //Limpiamos el carrito de compras
        Cart::clear();
        //Obtenemos detalles de la venta
        $detalles = SaleDetail::join('sales as s', 's.id', 'sale_details.sale_id')
        ->join("products as p", "p.id", "sale_details.product_id")
        ->select('p.id as idproducto','p.image as image','p.nombre as nombre','sale_details.price as po',
        'sale_details.price as pv','sale_details.quantity as cantidad')
        ->where('sale_details.sale_id', $idventa)
        ->orderBy('sale_details.id', 'asc')
        ->get();
        //Llenamos el carrito con las productos y sus cantidades 
        foreach ($detalles as $item)
        {
            Cart::add($item->idproducto, $item->nombre, $item->po, $item->cantidad, $item->image);
        }
        //Creando variable de sesión con el id de la venta
        session(['sesionidventa' => $idventa]);
        //session('sesionidventa')
        return redirect('pos');
    }

    public function cambiarusuario(Sale $venta)
    {
        $this->venta_id = $venta->id;
        $this->nombreusuariovendedor = User::find($venta->user_id)->name;
        $this->emit('show-cam-user');
    }
    public function seleccionarusuario($usuario)
    {
        $venta = Sale::find($this->venta_id);


        $venta->update([
            'user_id' => $usuario,
            ]);
        $venta->save();

        $this->emit('hide-cam-user');
    }

}
