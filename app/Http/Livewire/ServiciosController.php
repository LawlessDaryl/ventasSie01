<?php

namespace App\Http\Livewire;

use App\Models\ClienteMov;
use App\Models\Movimiento;
use App\Models\MovService;
use App\Models\OrderService;
use App\Models\CatProdService;
use App\Models\Cliente;
use App\Models\TypeWork;
use App\Models\User;
use App\Models\Service;
use App\Models\SubCatProdService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ServiciosController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $user, $cliente, $nombre, $cedula, $celular, $email, $nit, $razon_social, $orderservice, $hora_entrega,
        $movimiento, $typeworkid, $detalle, $categoryid, $from, $usuariolog, $catprodservid, $marc, $typeservice,
        $falla_segun_cliente, $diagnostico, $solucion, $saldo, $on_account, $import, $fecha_estimada_entrega,
        $search,  $condicion, $selected_id, $pageTitle, $buscarCliente, $service;
    private $pagination = 5;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'Detalle de la orden de servicio Noº: ';

        $this->categoryid = 'Elegir';
        $this->typeworkid = 'Elegir';
        $this->catprodservid = 'Elegir';

        $this->selected_id = 0;
        $this->typeservice = 'Normal';
        $this->saldo = 0;
        $this->on_account = 0;
        $this->import = 0;
        $this->condicion = 0;
        $this->from = Carbon::parse(Carbon::now())->format('d-m-Y  H:i');
        $this->fecha_estimada_entrega = Carbon::parse(Carbon::now())->format('d-m-Y');

        $this->hora_entrega = Carbon::parse(Carbon::now())->format('H:i');
        $this->usuariolog = Auth()->user()->name;
        if (!empty(session('od'))) {
            $this->orderservice = session('od');
        }
        if (!empty(session('clie'))) {
            $this->cliente = session('clie');
        }
    }
    public function render()
    {



        if (strlen($this->search) > 0) {

            $services = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                ->select('services.*', 'mov.type as tipo', 'mov.import as import', 'mov.saldo as saldo', 'mov.on_account as on_account', 'cat.nombre as category')
                ->where('services.order_service_id',  $this->orderservice)
                ->where('mov.status',  'ACTIVO')
                ->orderBy('services.id', 'desc')
                ->paginate($this->pagination);
        } else {

            $services = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
                ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
                ->select('services.*', 'mov.type as tipo', 'mov.import as import', 'mov.saldo as saldo', 'mov.on_account as on_account', 'cat.nombre as category')->where('services.order_service_id',  $this->orderservice)
                ->where('mov.status',  'ACTIVO')
                ->orderBy('services.id', 'desc')
                ->paginate($this->pagination);
        }

        $datos = [];
        if (strlen($this->buscarCliente) > 0) {
            $datos = Cliente::where('nombre', 'like', '%' . $this->buscarCliente . '%')
                ->orWhere('celular', 'like', '%' . $this->buscarCliente . '%')
                ->orWhere('cedula', 'like', '%' . $this->buscarCliente . '%')
                ->orderBy('cedula', 'desc')->get();
            if ($datos->count() > 0) {
                $this->condicion = 1;
            } else {
                $this->condicion = 0;
            }
        } else {
            $this->condicion = 0;
        }
        $typew = TypeWork::orderBy('name', 'asc')->get();
        $dato1 = CatProdService::orderBy('nombre', 'asc')->get();

        if ($this->catprodservid != 'Elegir') {
            $marca = SubCatProdService::where('cat_prod_service_id', $this->catprodservid)->orderBy('name', 'asc')->get();
        } else {
            $marca = [];
        }

        return view('livewire.servicio.component', [
            'data' => $services,
            'datos' => $datos,
            'work' => $typew,
            'cate' => $dato1,
            'marcas' => $marca,

        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Seleccionar($id)
    {
        $this->cliente = Cliente::find($id);
        session(['clie' =>   $this->cliente]);
        $this->resetUI();
        $this->emit('client-selected', 'Cliente Seleccionado');
    }
    public function StoreClient()
    {
        $rules = [
            'nombre' => 'required|min:1',
            'cedula' => 'required',
            'celular' => 'required'
        ];
        $messages = [
            'nombre.required' => 'Nombre es requerido',
            'nombre.min' => 'El nombre debe ser contener al menos 1 caracter',
            'cedula.required' => 'La cédula es requerida',
            'celular.required' => 'El celular es requerido'
        ];

        $this->validate($rules, $messages);
        $newclient = Cliente::create([
            'nombre' => $this->nombre,
            'cedula' => $this->cedula,
            'celular' => $this->celular,
            'email' => $this->email,
            'nit' => $this->nit,
            'razon_social' => $this->razon_social
        ]);
        $this->cliente = $newclient;
        session(['clie' => $this->cliente]);
        $this->resetUI();
        $this->emit('modalclient-selected', 'Cliente Registrado y Seleccionado');
    }
    //Store de Agregar Servicio
    public function Store()
    {


        $rules = [
            'typeworkid' => 'required',
            'catprodservid' => 'required',
            'marc' => 'required',
            'detalle' => 'required',
            'falla_segun_cliente' => 'required',
            'diagnostico' => 'required',
            'solucion' => 'required',
            'import' => 'required',
            'fecha_estimada_entrega' => 'required'
        ];
        $messages = [
            'typeworkid.required' => 'El Tipo de Trabajo es requerido',
            'catprodservid.required' => 'El Tipo de Equipo es requerido',
            'marc.required' => 'La Marca/Modelo es requerida',
            'detalle.required' => 'El Estado del Equipo es requerido',
            'falla_segun_cliente.required' => 'La Falla es requerida',
            'diagnostico.required' => 'El Diagnostico es requerido',
            'solucion.required' => 'La Solución es requerida',
            'import.required' => 'El Saldo es requerido',
            'fecha_estimada_entrega.required' => 'La Fecha es requerida'
        ];

        $this->validate($rules, $messages);


        DB::beginTransaction();
        try {

            if ($this->orderservice == 0) {
                $neworder = OrderService::create([
                    'type_service' => $this->typeservice,
                ]);
            } else {
                $neworder = OrderService::find($this->orderservice);
            }
            $from = Carbon::parse($this->fecha_estimada_entrega)->format('Y-m-d') . Carbon::parse($this->hora_entrega)->format(' H:i') . ':00';
            $newservice = Service::create([
                'type_work_id' => $this->typeworkid,
                'cat_prod_service_id' => $this->catprodservid,
                'marca' => $this->marc,
                'detalle' => $this->detalle,
                'falla_segun_cliente' => $this->falla_segun_cliente,
                'diagnostico' => $this->diagnostico,
                'solucion' => $this->solucion,
                'import' => $this->import,
                'fecha_estimada_entrega' => $from,
                'order_service_id' => $neworder->id
            ]);
            $mv = Movimiento::create([
                'type' => 'PENDIENTE',
                'status' => 'ACTIVO',
                'import' => $this->import,
                'on_account' => $this->on_account,
                'saldo' => $this->saldo,
                'user_id' => Auth()->user()->id,
            ]);
            MovService::create([
                'movimiento_id' => $mv->id,
                'service_id' => $newservice->id
            ]);
            ClienteMov::create([
                'movimiento_id' => $mv->id,
                'cliente_id' => $this->cliente->id
            ]);
            DB::commit();
            $this->orderservice = $neworder->id;
            session(['od' => $this->orderservice]);
            $this->resetUI();
            $this->emit('modal-selected', 'Servicio Registrado Correctamente');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }

    //Eliminar EDIT, no se usa
    public function Edit(Service $product)
    {
        $datosedit = Service::join('type_works as tw','tw.id','services.type_work_id')
        ->join('cat_prod_services as cps', 'cps.id','services.cat_prod_service_id')
        ->join('cps.id','sub_cat_prod_services.cat_prod_service_id')
        ->join('service.id','mov_services.service_id')
        ->join('movimientos.id','mov_services.movimiento_id')
        ->select('tw.name', 'cps.nombre','scps.name','movimientos.saldo','movimientos.on_account','movimientos.import')
        ->where('services.id',$product->id)
        ->get();
        //$typework = TypeWork::find($name, ['name']);
        $this->typeworkid = $product->typeworkid;
        $this->catprodservid = $product->catprodservid;
        $this->marc = $product->marc;
        $this->detalle = $product->detalle;
        $this->falla_segun_cliente = $product->falla_segun_cliente;
        $this->diagnostico = $product->diagnostico;
        $this->solucion = $product->solucion;
        //$sald = Movimiento::find($id, ['saldo']);
        $this->saldo = $product->saldo;
        $this->on_account = $product->on_account;
        $this->import = $product->import;
        $this->fecha_estimada_entrega = $product->fecha_estimada_entrega;

        $this->emit('modal-show', 'show modal!');
        
    }
    //Eliminar UPDATE, no se usa
    public function Update()
    {
        $rules = [
            'typeworkid' => "required|unique:type_works,typeworkid,{$this->selected_id}",
           
            'catprodservid' => 'required',
            'marc' => 'required',
            'detalle' => 'required',
            'falla_segun_cliente' => 'required',
            'diagnostico' => 'required',
            'solucion' => 'required',
            'import' => 'required',
            'fecha_estimada_entrega' => 'required'
        ];
        $messages = [
            'typeworkid.required' => 'El Tipo de Trabajo es requerido',
            'catprodservid.required' => 'El Tipo de Equipo es requerido',
            'marc.required' => 'La Marca/Modelo es requerida',
            'detalle.required' => 'El Estado del Equipo es requerido',
            'falla_segun_cliente.required' => 'La Falla es requerida',
            'diagnostico.required' => 'El Diagnostico es requerido',
            'solucion.required' => 'La Solución es requerida',
            'import.required' => 'El Saldo es requerido',
            'fecha_estimada_entrega.required' => 'La Fecha es requerida'
        ];

        $this->validate($rules, $messages);

        $product = Service::find($this->selected_id);
        $product->update([
            'type_work_id' => $this->typeworkid,
            'cat_prod_service_id' => $this->catprodservid,
            'marca' => $this->marc,
            'detalle' => $this->detalle,
            'falla_segun_cliente' => $this->falla_segun_cliente,
            'diagnostico' => $this->diagnostico,
            'solucion' => $this->solucion,
            'saldo' => $this->saldo,
            'on_account' => $this->on_account,
            'import' => $this->import,
            'fecha_estimada_entrega' => $this->fecha_estimada_entrega,
            'hora_entrega' => $this->hora_entrega
        ]);

        $this->resetUI();
        $this->emit('product-updated', 'Servicio Actualizado');
    }
    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Service $product)
    {
        $imageTemp = $product->image;
        $product->delete();

        if ($imageTemp != null) {
            if (file_exists('storage/productos/' . $imageTemp)) {
                unlink('storage/productos/' . $imageTemp);
            }
        }
        $this->resetUI();
        $this->emit('product-deleted', 'Producto Eliminado');
    }
    public function resetUI()
    {
        $this->categoryid = 'Elegir';
        $this->buscarCliente = '';
        $this->nombre = '';
        $this->cedula = '';
        $this->celular = '';
        $this->email = '';
        $this->nit = '';
        $this->razon_social = '';
        $this->condicion = 0;
        $this->typeworkid = 'Elegir';
        $this->detalle = '';
        $this->catprodservid = 'Elegir';
        $this->falla_segun_cliente = '';
        $this->diagnostico = '';
        $this->solucion = '';
        $this->saldo = 0;
        $this->on_account = 0;
        $this->import = 0;
        $this->fecha_estimada_entrega = '';
        $this->marc = '';
        $this->resetValidation();
    }
}
