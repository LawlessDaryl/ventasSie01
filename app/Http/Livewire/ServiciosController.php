<?php

namespace App\Http\Livewire;

use App\Models\ClienteMov;
use App\Models\Movimiento;
use App\Models\MovService;
use App\Models\OrderService;
use App\Models\CatProdService;
use App\Models\Cliente;
use App\Models\ProcedenciaCliente;
use App\Models\TypeWork;
use App\Models\User;
use App\Models\Service;
use App\Models\SubCatProdService;
use Carbon\Carbon;
use DateTime;
use Dompdf\Renderer\Text;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ServiciosController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $user, $cliente, $nombre, $cedula, $celular, $telefono, $email, $nit, $razon_social, $orderservice, $hora_entrega,
        $movimiento, $typeworkid, $detalle, $categoryid, $from, $usuariolog, $catprodservid, $marc, $typeservice,
        $falla_segun_cliente, $diagnostico, $solucion, $saldo, $on_account, $import, $fecha_estimada_entrega,
        $search,  $condicion, $selected_id, $pageTitle, $buscarCliente, $service, $type_service, $procedencia,
        $opciones, $estatus;
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
        $this->celular = '';
        $this->selected_id = 0;
        $this->marc = '';
        $this->diagnostico='Revisión';
        $this->solucion ='Revisión';
        $this->typeservice = 'NORMAL';
        $this->saldo = 0;
        $this->on_account = 0;
        $this->import = 0;
        $this->condicion = 0;
        $this->opciones = '';
        $this->from = Carbon::parse(Carbon::now())->format('d-m-Y  H:i');
        $this->fecha_estimada_entrega = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->estatus = '';
        $this->procedencia = 'Nuevo';

        $this->hora_entrega = Carbon::parse(Carbon::now())->format('H:i');
        $this->usuariolog = Auth()->user()->name;
        if (!empty(session('od'))) {
            $this->orderservice = session('od');
        }
        if (!empty(session('clie'))) {
            $this->cliente = session('clie');
        }
        if (!empty(session('tservice'))) {
            $this->typeservice = session('tservice');
            $this->type_service = session('tservice');
        }
    }
    public function render()
    {
        //$this->ResetSession();
        $services = Service::join('mov_services as ms', 'services.id', 'ms.service_id')
            ->join('cat_prod_services as cat', 'cat.id', 'services.cat_prod_service_id')
            ->join('movimientos as mov', 'mov.id', 'ms.movimiento_id')
            ->join('cliente_movs as cliemov', 'mov.id', 'cliemov.movimiento_id')
            ->join('clientes as c', 'c.id', 'cliemov.cliente_id')
            ->select('services.*', 'mov.type as tipo', 'mov.import as import', 'mov.saldo as saldo', 'mov.on_account as on_account', 'cat.nombre as category')->where('services.order_service_id',  $this->orderservice)
            ->where('mov.status',  'ACTIVO')
            ->orderBy('services.id', 'desc')
            ->paginate($this->pagination);


        $datos = [];
        if (strlen($this->buscarCliente) > 0) {
            $datos = Cliente::where('nombre', 'like', '%' . $this->buscarCliente . '%')
                ->orWhere('celular', 'like', '%' . $this->buscarCliente . '%')
                ->orWhere('telefono', 'like', '%' . $this->buscarCliente . '%')
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
            $marca = SubCatProdService::where('cat_prod_service_id', $this->catprodservid)
                ->orderBy('name', 'asc')
                ->get();
        } else {
            $marca = [];
        }

        if ((strlen($this->import)) != 0 && (strlen($this->on_account) != 0))
            $this->saldo = $this->import - $this->on_account;
        elseif ((strlen($this->on_account) == 0))
            $this->saldo = $this->import;
        elseif ((strlen($this->import) == 0))
            $this->saldo = 0;
        

        return view('livewire.servicio.component', [
            'data' => $services,
            'datos' => $datos,
            'work' => $typew,
            'cate' => $dato1,
            'marcas' => $marca,
            'procedenciaClientes' => ProcedenciaCliente::orderBy('id', 'asc')->get()

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

    public function ResetSession()
    {
        /* $this->cliente = '';
        $this->orderservice = ''; */
        session(['od' => null]);
        session(['clie' => null]);
        session(['tservice' => null]);
        $this->redirect('orderservice');
    }

    public function StoreClient()
    {   if($this->nit==''){
            $this->nit=0;
        }
        if($this->celular==''){
            $this->celular=0;
            
            if($this->telefono == ''){
                $this->telefono=0;

                $rules = [
                    'nombre' => 'required|min:1|unique:clientes',
                    'cedula' => 'required|max:10',
                    'celular' => 'numeric',
                    'telefono' => 'numeric',
                    'nit' => 'required|numeric',
                    'nit' => 'max:9'
                ];
                $messages = [
                    'nombre.required' => 'Nombre es requerido',
                    'nombre.min' => 'El nombre debe ser contener al menos 1 caracter',
                    'nombre.unique' => 'Ya existe el mismo Nombre registrado',
                    'cedula.required' => 'La cédula es requerida',
                    'cedula.max' => 'La cédula debe tener máximo 10 digitos',
                    'celular.numeric' => 'No puede ingresar letras',
                    'telefono.numeric' => 'No puede ingresar letras',
                    'nit.required' => 'Ingrese 0 si no quiere ingresar ningún nit',
                    'nit.numeric' => 'El nit debe ser un número',
                    'nit.max' => 'El nit no puede tener más de 9 digitos'
                ];
            }else{
                $rules = [
                    'nombre' => 'required|min:1|unique:clientes',
                    'cedula' => 'required|max:10',
                    'celular' => 'numeric',
                    'telefono' => 'numeric|digits:7',
                    'nit' => 'required|numeric',
                    'nit' => 'max:9'
                ];
                $messages = [
                    'nombre.required' => 'Nombre es requerido',
                    'nombre.min' => 'El nombre debe ser contener al menos 1 caracter',
                    'nombre.unique' => 'Ya existe el mismo Nombre registrado',
                    'cedula.required' => 'La cédula es requerida',
                    'cedula.max' => 'La cédula debe tener máximo 10 digitos',
                    'celular.numeric' => 'No puede ingresar letras',
                    'telefono.numeric' => 'No puede ingresar letras',
                    'telefono.digits' => 'Debe ingresar 7 digitos',
                    'nit.required' => 'Ingrese 0 si no quiere ingresar ningún nit',
                    'nit.numeric' => 'El nit debe ser un número',
                    'nit.max' => 'El nit no puede tener más de 9 digitos'
                ];
            }

            /* $rules = [
                'nombre' => 'required|min:1|unique:clientes',
                'cedula' => 'required|max:10',
                'celular' => 'numeric',
                'nit' => 'required|numeric',
                'nit' => 'max:9'
            ];
            $messages = [
                'nombre.required' => 'Nombre es requerido',
                'nombre.min' => 'El nombre debe ser contener al menos 1 caracter',
                'nombre.unique' => 'Ya existe el mismo Nombre registrado',
                'cedula.required' => 'La cédula es requerida',
                'cedula.max' => 'La cédula debe tener máximo 10 digitos',
                'celular.numeric' => 'No puede ingresar letras',
                'nit.required' => 'Ingrese 0 si no quiere ingresar ningún nit',
                'nit.numeric' => 'El nit debe ser un número',
                'nit.max' => 'El nit no puede tener más de 9 digitos'
            ]; */
    
        }else{
            if($this->telefono == ''){
                $this->telefono=0;

                $rules = [
                    'nombre' => 'required|min:1|unique:clientes',
                    'cedula' => 'required|max:10',
                    'celular' => 'required|numeric|digits:8',
                    'telefono' => 'numeric',
                    'nit' => 'required|numeric',
                    'nit' => 'max:9'
                ];
                $messages = [
                    'nombre.required' => 'Nombre es requerido',
                    'nombre.min' => 'El nombre debe ser contener al menos 1 caracter',
                    'nombre.unique' => 'Ya existe el mismo Nombre registrado',
                    'cedula.required' => 'La cédula es requerida',
                    'cedula.max' => 'La cédula debe tener máximo 10 digitos',
                    'celular.required' => 'El celular es requerido',
                    'celular.numeric' => 'No puede ingresar letras',
                    'celular.digits' => 'Debe ingresar 8 digitos',
                    'telefono.numeric' => 'No puede ingresar letras',
                    'nit.required' => 'Ingrese 0 si no quiere ingresar ningún nit',
                    'nit.numeric' => 'El nit debe ser un número',
                    'nit.max' => 'El nit no puede tener más de 9 digitos'
                ];
            }else{
                $rules = [
                    'nombre' => 'required|min:1|unique:clientes',
                    'cedula' => 'required|max:10',
                    'celular' => 'required|numeric|digits:8',
                    'telefono' => 'numeric|digits:7',
                    'nit' => 'required|numeric',
                    'nit' => 'max:9'
                ];
                $messages = [
                    'nombre.required' => 'Nombre es requerido',
                    'nombre.min' => 'El nombre debe ser contener al menos 1 caracter',
                    'nombre.unique' => 'Ya existe el mismo Nombre registrado',
                    'cedula.required' => 'La cédula es requerida',
                    'cedula.max' => 'La cédula debe tener máximo 10 digitos',
                    'celular.required' => 'El celular es requerido',
                    'celular.numeric' => 'No puede ingresar letras',
                    'celular.digits' => 'Debe ingresar 8 digitos',
                    'telefono.numeric' => 'No puede ingresar letras',
                    'telefono.digits' => 'Debe ingresar 7 digitos',
                    'nit.required' => 'Ingrese 0 si no quiere ingresar ningún nit',
                    'nit.numeric' => 'El nit debe ser un número',
                    'nit.max' => 'El nit no puede tener más de 9 digitos'
                ];
            }

            /* $rules = [
                'nombre' => 'required|min:1|unique:clientes',
                'cedula' => 'required|max:10',
                'celular' => 'required|numeric|digits:8',
                'nit' => 'required|numeric',
                'nit' => 'max:9'
            ];
            $messages = [
                'nombre.required' => 'Nombre es requerido',
                'nombre.min' => 'El nombre debe ser contener al menos 1 caracter',
                'nombre.unique' => 'Ya existe el mismo Nombre registrado',
                'cedula.required' => 'La cédula es requerida',
                'cedula.max' => 'La cédula debe tener máximo 10 digitos',
                'celular.required' => 'El celular es requerido',
                'celular.numeric' => 'No puede ingresar letras',
                'celular.digits' => 'Debe ingresar 8 digitos',
                'nit.required' => 'Ingrese 0 si no quiere ingresar ningún nit',
                'nit.numeric' => 'El nit debe ser un número',
                'nit.max' => 'El nit no puede tener más de 9 digitos'
            ]; */
        }
        
        $this->validate($rules, $messages);
        if ($this->procedencia == 'Nuevo') {
            $procd = ProcedenciaCliente::where('procedencia', 'Nuevo')->get()->first();
            $newclient = Cliente::create([
                'nombre' => $this->nombre,
                'cedula' => $this->cedula,
                'celular' => $this->celular,
                'telefono' => $this->telefono,
                'email' => $this->email,
                'nit' => $this->nit,
                'razon_social' => $this->razon_social,
                'procedencia_cliente_id' => $procd->id,
            ]);
        } else {
            $newclient = Cliente::create([
                'nombre' => $this->nombre,
                'cedula' => $this->cedula,
                'celular' => $this->celular,
                'telefono' => $this->telefono,
                'email' => $this->email,
                'razon_social' => $this->razon_social,
                'nit' => $this->nit,
                'procedencia_cliente_id' => $this->procedencia,
            ]);
        }
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
            'on_account' => 'required',
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
            'on_account.required' => 'Si no desea ingresar nada ingrese "0"',
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
            
            $from = Carbon::parse($this->fecha_estimada_entrega)->format('Y-m-d') ." " . $this->hora_entrega . ':00';
            $newservice = Service::create([
                'type_work_id' => $this->typeworkid,
                'cat_prod_service_id' => $this->catprodservid,
                'marca' => $this->marc,
                'detalle' => $this->detalle,
                'falla_segun_cliente' => $this->falla_segun_cliente,
                'diagnostico' => $this->diagnostico,
                'solucion' => $this->solucion,
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
        session(['tservice' => $this->typeservice]);
    }


    public function Edit(Service $service)
    {
        $movimiento_Serv = Service::join('mov_services as ms', 'ms.service_id', 'services.id')
            ->join('movimientos as m', 'ms.movimiento_id', 'm.id')
            ->select('m.on_account as on_account', 'm.saldo as saldo', 'm.import as import', 'm.type')
            ->where('services.id', $service->id)
            ->where('m.status', 'ACTIVO')
            ->get()->first();

        $this->selected_id = $service->id;
        $this->typeworkid = $service->type_work_id;
        $this->catprodservid = $service->cat_prod_service_id;
        $this->marc = $service->marca;
        $this->detalle = $service->detalle;
        $this->falla_segun_cliente = $service->falla_segun_cliente;
        $this->diagnostico = $service->diagnostico;
        $this->solucion = $service->solucion;
        $this->fecha_estimada_entrega = substr($service->fecha_estimada_entrega, 0, 10);
        $this->hora_entrega = substr($service->fecha_estimada_entrega, 11, 14);
        $this->import = $movimiento_Serv->import;
        $this->on_account = $movimiento_Serv->on_account;
        $this->saldo = $movimiento_Serv->saldo;
        $this->opciones = $movimiento_Serv->type;
        $this->emit('modal-show', 'show modal!');

        $servicioss = Service::find($this->selected_id);
        foreach($servicioss->movservices as $mm){
            if($mm->movs->status == 'ACTIVO'){
                $this->estatus = $mm->movs->type;
            }
        }
    }
    public function ChangeTypeService()
    {
        if ($this->orderservice != 0) {
            $Ordservice = OrderService::find($this->orderservice);
            $Ordservice->type_service = $this->type_service;
            $Ordservice->save();
        }
        $Ordservice = OrderService::find($this->orderservice);
        session(['tservice' => $this->type_service]);
        $this->typeservice = $this->type_service;

        $this->emit('tipoServ-updated', 'Servicio Actualizado');
    }
    //Update de Servicios
    public function Update()
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
            'on_account' => 'required',
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
            'on_account.required' => 'Si no desea ingresar nada ingrese "0"',
            'fecha_estimada_entrega.required' => 'La Fecha es requerida'
        ];

        $this->validate($rules, $messages);
        DB::beginTransaction();
        /* dd($this->hora_entrega); */
        try {
            $from = Carbon::parse($this->fecha_estimada_entrega)->format('Y-m-d') ." " . $this->hora_entrega;
            $service = Service::find($this->selected_id);
            
            $service->update([
                'type_work_id' => $this->typeworkid,
                'cat_prod_service_id' => $this->catprodservid,
                'marca' => $this->marc,
                'detalle' => $this->detalle,
                'falla_segun_cliente' => $this->falla_segun_cliente,
                'diagnostico' => $this->diagnostico,
                'solucion' => $this->solucion,
                'fecha_estimada_entrega' => $from,
            ]);
            
            $servicioss = Service::find($this->selected_id);
            foreach($servicioss->movservices as $mm){
                if($mm->movs->status == 'ACTIVO'){
                    $this->estatus = $mm->movs->type;
                }
            }
            
            if($this->estatus == 'TERMINADO' && $this->opciones == 'PENDIENTE'){
                foreach($servicioss->movservices as $mm){
                    if($mm->movs->type == 'TERMINADO' || $mm->movs->type == 'PROCESO'){
                        $ClienteMov = ClienteMov::find($mm->movs->climov->id);
                        $ClienteMov->delete();
                        $movServ = MovService::find($mm->id);
                        $movServ->delete();
                        $movim = Movimiento::find($mm->movs->id);
                        $movim->delete();
                    }
                    if($mm->movs->type == 'PENDIENTE'){
                        $movimi = Movimiento::find($mm->movs->id);
                        $movimi->status = 'ACTIVO';
                        $movimi->save();
                    }
                }
            }elseif($this->estatus == 'TERMINADO' && $this->opciones == 'PROCESO'){
                foreach($servicioss->movservices as $mm){
                    if($mm->movs->type == 'TERMINADO'){
                        $ClienteMov = ClienteMov::find($mm->movs->climov->id);
                        $ClienteMov->delete();
                        $movServ = MovService::find($mm->id);
                        $movServ->delete();
                        $movim = Movimiento::find($mm->movs->id);
                        $movim->delete();
                    }
                    if($mm->movs->type == 'PROCESO'){
                        $movimi = Movimiento::find($mm->movs->id);
                        $movimi->status = 'ACTIVO';
                        $movimi->save();
                    }
                }
            }elseif($this->estatus == 'PROCESO' && $this->opciones == 'PENDIENTE'){
                foreach($servicioss->movservices as $mm){
                    if($mm->movs->type == 'PROCESO'){
                        $ClienteMov = ClienteMov::find($mm->movs->climov->id);
                        $ClienteMov->delete();
                        $movServ = MovService::find($mm->id);
                        $movServ->delete();
                        $movim = Movimiento::find($mm->movs->id);
                        $movim->delete();
                    }
                    if($mm->movs->type == 'PENDIENTE'){
                        $movimi = Movimiento::find($mm->movs->id);
                        $movimi->status = 'ACTIVO';
                        $movimi->save();
                    }
                }
            }elseif($this->estatus == 'ABANDONADO' && $this->opciones == 'TERMINADO'){
                foreach($servicioss->movservices as $mm){
                    if($mm->movs->type == 'ABANDONADO'){
                        $ClienteMov = ClienteMov::find($mm->movs->climov->id);
                        $ClienteMov->delete();
                        $movServ = MovService::find($mm->id);
                        $movServ->delete();
                        $movim = Movimiento::find($mm->movs->id);
                        $movim->delete();
                    }
                    if($mm->movs->type == 'TERMINADO'){
                        $movimi = Movimiento::find($mm->movs->id);
                        $movimi->status = 'ACTIVO';
                        $movimi->save();
                    }
                }
                $servicioss->fecha_estimada_entrega = new DateTime("now");
                $servicioss->save();
            }elseif($this->estatus == 'ABANDONADO' && $this->opciones == 'PROCESO'){
                foreach($servicioss->movservices as $mm){
                    if($mm->movs->type == 'ABANDONADO'  || $mm->movs->type == 'TERMINADO'){
                        $ClienteMov = ClienteMov::find($mm->movs->climov->id);
                        $ClienteMov->delete();
                        $movServ = MovService::find($mm->id);
                        $movServ->delete();
                        $movim = Movimiento::find($mm->movs->id);
                        $movim->delete();
                    }
                    if($mm->movs->type == 'PROCESO'){
                        $movimi = Movimiento::find($mm->movs->id);
                        $movimi->status = 'ACTIVO';
                        $movimi->save();
                    }
                }
                $servicioss->fecha_estimada_entrega = new DateTime("now");
                $servicioss->save();
            }elseif($this->estatus == 'ABANDONADO' && $this->opciones == 'PENDIENTE'){
                foreach($servicioss->movservices as $mm){
                    if($mm->movs->type == 'ABANDONADO'  || $mm->movs->type == 'TERMINADO' || $mm->movs->type == 'PROCESO'){
                        $ClienteMov = ClienteMov::find($mm->movs->climov->id);
                        $ClienteMov->delete();
                        $movServ = MovService::find($mm->id);
                        $movServ->delete();
                        $movim = Movimiento::find($mm->movs->id);
                        $movim->delete();
                    }
                    if($mm->movs->type == 'PENDIENTE'){
                        $movimi = Movimiento::find($mm->movs->id);
                        $movimi->status = 'ACTIVO';
                        $movimi->save();
                    }
                }
                $servicioss->fecha_estimada_entrega = new DateTime("now");
                $servicioss->save();
            }
            
            

            DB::commit();
            $this->resetUI();
            $this->emit('service-updated', 'Servicio Actualizado');

        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'ERROR' . $e->getMessage());
        }
    }
    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Service $service)
    {
        $ids = Service::join('mov_services as ms', 'ms.service_id', 'services.id')
            ->join('movimientos as m', 'ms.movimiento_id', 'm.id')
            ->join('cliente_movs as cm', 'cm.movimiento_id', 'm.id')
            ->select(
                'ms.movimiento_id as movimiendoID',
                'cm.id as clientemovID',
                'ms.id as servicemovID'
            )
            ->where('services.id', $service->id)
            ->get()->first();

        $movCliente = ClienteMov::find($ids->clientemovID);
        $movCliente->delete();
        $movService = MovService::find($ids->servicemovID);
        $movService->delete();
        $movimiento = Movimiento::find($ids->movimiendoID);
        $movimiento->delete();
        $service->delete();

        if ($this->orderservice  != 0) {
            $neworder = OrderService::find($this->orderservice);
            if ($neworder->services->count() == 0) {
                $neworder->delete();
                session(['od' => 0]);
                session(['clie' => ""]);
                $this->orderservice = 0;
                $this->cliente = "";
            }
        }

        $this->resetUI();
        $this->emit('service-deleted', 'Servicio Eliminado');
    }
    public function resetUI()
    {
        $this->categoryid = 'Elegir';
        $this->typeworkid = 'Elegir';
        $this->catprodservid = 'Elegir';
        $this->selected_id = 0;
        $this->typeservice = 'NORMAL';
        $this->saldo = 0;
        $this->on_account = 0;
        $this->import = 0;
        $this->condicion = 0;
        $this->from = Carbon::parse(Carbon::now())->format('d-m-Y  H:i');
        $this->fecha_estimada_entrega = Carbon::parse(Carbon::now())->format('Y-m-d');
        $this->hora_entrega = Carbon::parse(Carbon::now())->format('H:i');
        $this->buscarCliente = '';
        $this->nombre = '';
        $this->cedula = '';
        $this->celular = '';
        $this->telefono = '';
        $this->email = '';
        $this->nit = '';
        $this->razon_social = '';
        $this->detalle = '';
        $this->falla_segun_cliente = '';
      
        $this->marc = '';
        $this->resetValidation();
        $this->diagnostico='Revisión';
        $this->solucion ='Revisión';
    }
}
