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
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ServiciosController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $user, $cliente, $nombre, $cedula, $celular, $email, $nit, $razon_social, $orderservice, 
    $movimiento, $typeworkid, $detalle, $categoryid, $from,$usuariolog,$catprodservid,
    $falla_segun_cliente, $diagnostico, $solucion, $saldo, $on_account, $import,$fecha_estimada_entrega, $search,  $condicion,
    $selected_id, $pageTitle,$buscarCliente;
    private $pagination = 5;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function mount()
    {
        $this->pageTitle = 'Detalle de la orden de servicio Noº: ';
        
        $this->categoryid = 'Elegir';
        $this->orderservice = 0;
         
        $this->condicion = 0;
        $this->from = Carbon::parse(Carbon::now())->format('d-m-Y  H:s')  ;
        $this->usuariolog =Auth()->user()->name;
    }
    public function render()
    {
        if (strlen($this->search) > 0) {
            if ( $this->orderservice != 0){
                $services = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
                ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
                ->join('users as u', 'u.id', 'mov.user_id')
                ->select('services.*', 'mov.status as status', 'u.name as usuario')
                ->where('services.order_service_id',  $this->orderservice )
                ->where('mov.status',  'ACTIVO' )
             
                ->orderBy('services.id', 'desc')
                ->paginate($this->pagination);
          
            }
          
           

            
        } else {
            $services = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
            ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
            ->join('users as u', 'u.id', 'mov.user_id')
            ->select('services.*', 'mov.status as status', 'u.name as usuario')
            ->where('services.order_service_id',  $this->orderservice )
            ->where('mov.status',  'ACTIVO' )
         
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
        }else{ 
            $this->condicion = 0;
        }

        return view('livewire.servicio.component', [
            'data' => $services,
            'datos' => $datos,
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Seleccionar($id)
    {
        $this->cliente = Cliente::find($id);
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
        $this->cliente=$newclient;
        $this->resetUI();
        $this->emit('modalclient-selected', 'Cliente Registrado y Seleccionado');
    }
    //Store de Agregar Servicio
    public function Store()
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
        $this->cliente=$newclient;
        $this->resetUI();
        $this->emit('modalclient-selected', 'Cliente Registrado y Seleccionado');
    }

    //Eliminar EDIT, no se usa
    public function Edit(Service $product)
    {
        $this->selected_id = $product->id;
        $this->name = $product->name;
        $this->barcode = $product->barcode;
        $this->cost = $product->cost;
        $this->price = $product->price;
        $this->stock = $product->stock;
        $this->alerts = $product->alerts;
        $this->categoryid = $product->category_id;
        $this->image = null;

        $this->emit('modal-show', 'show modal!');
    }
    //Eliminar UPDATE, no se usa
    public function Update()
    {
        $rules = [
            'name' => "required|min:3|unique:products,name,{$this->selected_id}",
            'cost' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'alerts' => 'required',
            'categoryid' => 'required|not_in:Elegir'
        ];
        $messages = [
            'name.required' => 'Nombre del producto requerido',
            'name.unique' => 'Ya existe el nombre del producto',
            'name.min' => 'El nombre debe ser contener al menos 3 caracteres',
            'cost.required' => 'El costo es requerido',
            'price.required' => 'El precio es requerido',
            'stock.required' => 'El stock es requerido',
            'alerts.required' => 'Ingresa el valor minimo en existencias',
            'categoryid.not_int' => 'Elegir un nombre de categoria diferente de elegir',
        ];
        $this->validate($rules, $messages);
        $product = Service::find($this->selected_id);
        $product->update([
            'name' => $this->name,
            'cost' => $this->cost,
            'price' => $this->price,
            'barcode' => $this->barcode,
            'stock' => $this->stock,
            'alerts' => $this->alerts,
            'category_id' => $this->categoryid
        ]);
        
        $this->resetUI();
        $this->emit('product-updated', 'Producto Actualizado');
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
        $this->buscarCliente='';
        $this->nombre = '';
        $this->cedula='';
        $this->celular='';
        $this->email='';
        $this->nit = '';
        $this->razon_social = '';
        $this->condicion = 0;

        $this->resetValidation();
    }


}