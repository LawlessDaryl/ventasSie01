<?php

namespace App\Http\Livewire;

use App\Models\CatProdService;
use App\Models\ClienteMov;
use App\Models\Movimiento;
use App\Models\MovService;
use App\Models\Service;
use App\Models\OrderService;
use App\Models\SubCatProdService;
use App\Models\TypeWork;
use App\Models\User;
use Carbon\Carbon;
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
    ,$detalle1,$falla_segun_cliente,$nombreCliente,$celular,$usuarioId,
    $typew, $typeworkid, $catprodservid, $diagnostico, $solucion, $hora_entrega;


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

        $this->typeworkid = '';
        $this->catprodservid = '';
        $this->diagnostico = '';
        $this->solucion = '';
        $this->fecha_estimada_entrega = '';
        $this->hora_entrega = '';
        $this->import = 0;
        $this->on_account = 0;
        $this->saldo = 0;
        $this->detalle= '';
        
        
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
        $typew = TypeWork::orderBy('name', 'asc')->get();
        $dato1 = CatProdService::orderBy('nombre', 'asc')->get();
        if ($this->catprodservid != 'Elegir') {
            $marca = SubCatProdService::where('cat_prod_service_id', $this->catprodservid)->orderBy('name', 'asc')->get();
        } else {
            $marca = [];
        }

        if ((strlen($this->import)) != 0 && (strlen($this->on_account) != 0))
        $this->saldo = $this->import - $this->on_account;
        elseif((strlen($this->on_account) == 0))
        $this->saldo = $this->import;
        elseif((strlen($this->import) == 0))
        $this->saldo = 0;


        return view('livewire.order_service.component', [
            'data' => $orderservices,
            'users' => $users,
            'work' => $typew,
            'cate' => $dato1,
            'marcas' => $marca,
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

    public function Detalles($id)
    {


        $this->service1 = Service::find($id);
        $this->movimiento= Movimiento::find($id);

        $this->typeworkid = $this->service1->type_work_id;
        $this->catprodservid = $this->service1->cat_prod_service_id;
        $this->diagnostico = $this->service1->diagnostico;
        $this->solucion = $this->service1->solucion;
        $this->fecha_estimada_entrega = substr($this->service1->fecha_estimada_entrega, 0, 10);
        $this->hora_entrega = substr($this->service1->fecha_estimada_entrega, 11, 14);
        $this->import = $this->movimiento->import;
        $this->on_account = $this->movimiento->on_account;
        $this->saldo = $this->movimiento->saldo;
        $this->detalle=$this->service1->detalle;
        
        $this->categoria=$this->service1->categoria->nombre;
        $this->marca=$this->service1->marca;
        $this->numeroOrden=$this->service1->order_service_id;
        $this->detalle1=$this->service1->detalle;
        $this->falla_segun_cliente=$this->service1->falla_segun_cliente;
        $this->nombreCliente=$this->service1->movservices[0]->movs->climov->client->nombre;
        $this->celular=$this->service1->movservices[0]->movs->climov->client->celular;
        $this->usuarioId=$this->service1->movservices[0]->movs->user_id;

        $this->emit('show-detail', 'show modal!');
    }

    public function GuardarCambio(Service $service)
    {
        $rules = [
        ];
        $messages = [
        ];


        $from = Carbon::parse($this->fecha_estimada_entrega)->format('Y-m-d') . Carbon::parse($this->hora_entrega)->format(' H:i') . ':00';
        $service->update([
         
            'type_work_id' => $this->typeworkid,
            'cat_prod_service_id' => $this->catprodservid,
            'marca' => $this->marca,
            'detalle' => $this->detalle,
            'falla_segun_cliente' => $this->falla_segun_cliente,
            'diagnostico' => $this->diagnostico,
            'solucion' => $this->solucion,
            'fecha_estimada_entrega' => $from,
            

        ]);

        $this->movimiento->update([
            'import' => $this->import,
            'on_account' => $this->on_account,
            'saldo' => $this->saldo,
        ]);

           /* $this->typeworkid = $this->service1->type_work_id;
            $this->catprodservid = $this->service1->cat_prod_service_id;
            $this->marca = $this->service1->marca;
            $this->detalle = $this->service1->detalle;
            $this->falla_segun_cliente = $this->service1->falla_segun_cliente;
            $this->diagnostico = $this->service1->diagnostico;
            $this->solucion = $this->service1->solucion;
            $this->import = $this->movimiento->import;
            $this->on_account = $this->movimiento->on_account;
            $this->saldo = $this->movimiento->saldo;
            $this->fecha_estimada_entrega = substr($this->service1->fecha_estimada_entrega, 0, 10);
            $this->hora_entrega = substr($this->service1->fecha_estimada_entrega, 11, 14);
*/

        $this->resetUI();
        $this->emit('detail-hide-msg', 'Servicio Actualizado');
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


    public function CambioProceso(Service $service)
    {
      
       foreach($service->movservices as $servmov)
       {

           if($servmov->movs->status == 'ACTIVO' && $servmov->movs->type == 'PROCESO')
           {
                $movimiento= $servmov->movs;
                
                DB::beginTransaction();
                try {
                    if(Auth::user()->hasPermissionTo('Asignar_Tecnico_Servicio')){
                        $mv = Movimiento::create([
                            'type' => 'TERMINADO',
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
                    $this->GuardarCambio($service);
                    $this->resetUI();
                    $this->emit('product-added', 'Servicio en Proceso');
                } catch (Exception $e) {
                    DB::rollback();
                    $this->emit('item-error', 'ERROR' . $e->getMessage());
                }
                
           }
        }
    }

    public function CambioTerminado(Service $service)
    {
      
       foreach($service->movservices as $servmov)
       {

           if($servmov->movs->status == 'ACTIVO' && $servmov->movs->type == 'TERMINADO')
           {
                $movimiento= $servmov->movs;
                
                DB::beginTransaction();
                try {
                    if(Auth::user()->hasPermissionTo('Asignar_Tecnico_Servicio')){
                        $mv = Movimiento::create([
                            'type' => 'ENTREGADO',
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
                    $this->GuardarCambio($service);
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

        $this->typeworkid = '';
        $this->catprodservid = '';
        $this->diagnostico = '';
        $this->solucion = '';
        $this->fecha_estimada_entrega = '';
        $this->hora_entrega = '';
        $this->import = 0;
        $this->on_account = 0;
        $this->saldo = 0;
        $this->detalle= '';


        $this->resetValidation();
    }
}
