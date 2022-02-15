<?php

namespace App\Http\Livewire;

use App\Models\ClienteMov;
use App\Models\Movimiento;
use App\Models\MovService;
use App\Models\Service;
use App\Models\OrderService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class OrderServiceController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $search, $selected_id, $pageTitle, $componentName,
    $cliente, $fecha_estimada_entrega, $detalle, $status, $saldo, $on_account, $import, 
    $serviceid, $movtype, $orderservice, $users1,$service1,$categoria,$marca,$numeroOrden
    ,$detalle1,$falla_segun_cliente,$nombreCliente,$celular,$usuarioId;


    private $pagination = 5;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Ordenes de Servicio';
        $this->usuarioId=-1;
        
        
    }
    public function render()
    {
        if (strlen($this->search) > 0) {
            //$orderservices = OrderService::orderBy('id','desc')
            //->paginate($this->pagination);


            $orderservices = OrderService::join('services as s', 'order_services.id', 
            's.order_service_id')
            ->join('mov_services as ms', 's.id', 'ms.service_id')
            ->join('cat_prod_services as cat', 'cat.id', 's.cat_prod_service_id')
            ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
            ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
            ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
            ->select('order_services.*')
            ->where('c.nombre', 'like', '%' . $this->search . '%')
            ->orWhere('order_services.id', 'like', '%' . $this->search . '%')
            ->orWhere('order_services.type_service', 'like', '%' . $this->search . '%')
            ->orWhere('cat.nombre', 'like', '%' . $this->search . '%')
            ->orWhere('s.detalle', 'like', '%' . $this->search . '%')
            ->orWhere('s.marca', 'like', '%' . $this->search . '%')
            ->orWhere('s.falla_segun_cliente', 'like', '%' . $this->search . '%')
            ->orWhere('mov.type', 'like', '%' . $this->search . '%')
            ->orWhere('mov.import', 'like', '%' . $this->search . '%')
            //->where('services.order_service_id',  $this->orderservice)
            //->where('mov.status',  'ACTIVO')
            ->orderBy('order_services.id', 'desc')
            ->paginate($this->pagination);


        } else {
            $orderservices =OrderService::orderBy('id','desc')
            ->paginate($this->pagination);
        }
        $users =User::all();
       
       
        return view('livewire.order_service.component', [
            'data' => $orderservices,
            'users' => $users,
            'ordserv' => OrderService::orderBy('order_services.id', 'asc')
            ->get()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function GoService()
    {
        session(['od' => null]);
        session(['clie' => null]);
        session(['tservice' => null]);
        $this->redirect('service');
    }

    
    public function Edit($id)
    {
        $this->service1 = Service::find($id);
        
        $this->categoria=$this->service1->categoria->nombre;
        $this->marca=$this->service1->marca;
        $this->numeroOrden=$this->service1->order_service_id;
        $this->detalle1=$this->service1->detalle;
        $this->falla_segun_cliente=$this->service1->falla_segun_cliente;
        $this->nombreCliente=$this->service1->movservices[0]->movs->climov->client->nombre;
        $this->celular=$this->service1->movservices[0]->movs->climov->client->celular;
        $this->usuarioId=$this->service1->movservices[0]->movs->user_id;
        $this->emit('show-modal', 'show modal!');
    }

    public function Cambio(Service $service)
    {
      
       foreach($service->movservices as $servmov)
       {

           if($servmov->movs->status == 'ACTIVO' && $servmov->movs->type == 'PENDIENTE')
           {
                $movimiento= $servmov->movs;
                
                DB::beginTransaction();
                try {
                    if(Auth::user()->hasPermissionTo('Asignar_Tecnico_Servicio')){
                    $mv = Movimiento::create([
                        'type' => 'PROCESO',
                        'status' => 'ACTIVO',
                        'import' => $movimiento->import,
                        'on_account' => $movimiento->on_account,
                        'saldo' => $movimiento->saldo,
                        'user_id' => $this->users1,
                    ]);
                }else{
                    $mv = Movimiento::create([
                        'type' => 'PROCESO',
                        'status' => 'ACTIVO',
                        'import' => $movimiento->import,
                        'on_account' => $movimiento->on_account,
                        'saldo' => $movimiento->saldo,
                        'user_id' => Auth()->user()->id,
                    ]);
                }
                    MovService::create([
                        'movimiento_id' => $mv->id,
                        'service_id' => $service->id
                    ]);
                    ClienteMov::create([
                        'movimiento_id' => $mv->id,
                        'cliente_id' => $movimiento->climov->cliente_id,
                    ]);
        
                    DB::commit();
                    $movimiento->update([
                        'status' =>'INACTIVO'
                        
                    ]);
                    $this->resetUI();
                    $this->emit('product-added', 'Servicio en Proceso');
                } catch (Exception $e) {
                    DB::rollback();
                    $this->emit('item-error', 'ERROR' . $e->getMessage());
                }
                
           }
      
       }
    }


    
    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(OrderService $product)
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
        $this->name = '';
        $this->barcode = '';
        $this->cost = '';
        $this->price = '';
        $this->stock = '';
        $this->alerts = '';
        $this->search = '';
        $this->categoryid = 'Elegir';
        $this->image = null;
        $this->selected_id = 0;

        $this->categoria = '';
        $this->marca = '';
        $this->numeroOrden = '';
        $this->detalle1 = '';
        $this->falla_segun_cliente = '';
        $this->nombreCliente = '';
        $this->celular = 0;
        $this->usuarioId = -1;

        $this->resetValidation();
    }
}
