<?php

namespace App\Http\Livewire;

use App\Models\Cartera;
use App\Models\CarteraMov;
use App\Models\Cliente;
use App\Models\ClienteMov;
use App\Models\FreePlans;
use App\Models\FreeSale;
use App\Models\Movimiento;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class FreeSaleController extends Component
{
    public $paginacion;
    //Datos para guardar una venta FreeFire
    public $nameclient, $idgame, $alias, $freeplan_id, $cryptocurrencies;

    //Total Bs de una Venta
    public $total_bs;
    //Id de un cliente seleccionado
    public $cliente_id;
    //Id de una cartera seleccionada
    public $cartera_id;
    //Id de una venta realizada
    public $venta_id;
    //Guarda el mensaje que se mostrará en un mensaje totast
    public $mensaje_toast;

    //Variable que almacena el nombre de un cliente para su busqueda
    public $buscarcliente;
    //Variables para crear un cliente
    public $cliente_nombre, $cliente_ci, $cliente_celular;

    //Guarda el nombre y numero del cliente seleccionado
    public $nombrecliente, $celularcliente;


    public function mount()
    {
        $this->cliente_id = 0;
        $this->paginacion = 50;
    }

    use WithPagination;
    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }
    public function render()
    {


        //Lista a todos los clientes que tengan el nombre de la variable $this->buscarcliente
        $listaclientes = [];
        if(strlen($this->buscarcliente) > 0)
        {
            $listaclientes = Cliente::select("clientes.*")
            ->where('clientes.nombre', 'like', '%' . $this->buscarcliente . '%')
            ->where('clientes.celular', '>', 0)
            ->orderBy("clientes.created_at","desc")
            ->get();
        }


        if($this->cliente_id > 0)
        {
            $this->nombrecliente = Cliente::find($this->cliente_id)->nombre;
            $this->celularcliente = Cliente::find($this->cliente_id)->celular;
        }
        else
        {
            $this->nombrecliente = "Seleccione Cliente";
            $this->celularcliente = "Seleccione Cliente";
        }



        $listsales = FreeSale::join("free_plans as fp", "fp.id", "free_sales.free_plan_id")
        ->select("free_sales.nameclient as nameclient","free_sales.phone as phone","free_sales.idaccount as idaccount", "free_sales.alias as alias",
        "fp.nameplan as nameplan", "fp.cryptocurrencies as cryptocurrencies", "free_sales.created_at as created_at", "fp.cost as cost")
        ->orderBy("free_sales.created_at","desc")
        ->paginate($this->paginacion);


        return view('livewire.freesale.freesale', [
            'listplans' => FreePlans::all(),
            'listsales' => $listsales,
            'carteras' => Cartera::all(),
            'listaclientes' => $listaclientes
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    public function showmodalnewsale()
    {
        if($this->cartera_id > 0)
        {
            $this->emit('show-modal-sale');
        }
        else
        {
            $this->emit('show-elegircartera');
        }
    }
    public function savesale()
    {

        //Reglas de Validación
        $rules = [
            'idgame' => 'required',
            'alias' => 'required',
            'freeplan_id' => 'required|not_in:elegir',
        ];
        $messages = [
            'idgame.required' => 'Requerido',
            'alias.required' => 'Requerido',
            'freeplan_id.required' => 'Seleccione por favor',
        ];

        $this->validate($rules, $messages);



        $totalbs = FreePlans::find($this->freeplan_id);



        DB::beginTransaction();
        try
        {
            //Creando Movimiento
            $Movimiento = Movimiento::create([
                'type' => "FREEFIRE",
                'import' => $totalbs->cost,
                'user_id' => Auth()->user()->id,
            ]);
            //Creando Cliente Movimiento
            ClienteMov::create([
                'movimiento_id' => $Movimiento->id,
                'cliente_id' => $this->cliente_id,
            ]);
            //Para saber toda la informacion del id de la cartera seleccionada
            $cartera = Cartera::find($this->cartera_id);
            //Creando la venta
            $sale = FreeSale::create([
                'nameclient' => $this->nombrecliente,
                'phone'=>$this->celularcliente,
                'idaccount'=>$this->idgame,
                'alias'=> $this->alias,
                'free_plan_id'=> $this->freeplan_id,
                'sucursals_id'=> $this->idsucursal(),
                'user_id'=> Auth()->user()->id,
                'movimiento_id'=> $Movimiento->id,
                'cartera_id'=> $this->cartera_id,
            ]);
            $sale->save();

            //Actualizando la variable $this->venta_id para mostrarlo en un mensaje toast arriba a la izquierda de la pantalla
            $this->venta_id = $sale->id;

            //Creando Cartera Movimiento
            CarteraMov::create([
                'type' => "INGRESO",
                'tipoDeMovimiento' => "VENTA",
                'comentario' => "Venta FreeFire",
                'cartera_id' => $this->cartera_id,
                'movimiento_id' => $Movimiento->id,
            ]);


            // $this->resetUI();
            $this->mensaje_toast = "¡Venta FreeFire con el código: '" . $sale->id . "' realizada exitosamente!";
            $this->emit('modal-hide-sale');

            DB::commit();
            
        }
        catch (Exception $e)
        {
            DB::rollback();
            $this->mensaje_toast = ": ".$e->getMessage();
            $this->emit('sale-error');
        }
    }
    
    //Obtener el Id de la Sucursal Donde esta el Usuario
    public function idsucursal()
    {
        $idsucursal = User::join("sucursal_users as su","su.user_id","users.id")
        ->select("su.sucursal_id as id","users.name as n")
        ->where("users.id", Auth()->user()->id)
        ->where("su.estado","ACTIVO")
        ->get()
        ->first();
        return $idsucursal->id;
    }

    //llama al modal buscarcliente
    public function modalbuscarcliente()
    {
        $this->emit('show-buscarcliente');
    }
    //llama al modal crearcliente
    public function modalcrearcliente()
    {
        $this->emit('show-crearcliente');
    }
    //Crear cliente
    public function crearcliente()
    {
        //Reglas de Validación
        $rules = [
            'cliente_nombre' => 'required',
            'cliente_celular' => 'required',
        ];
        $messages = [
            'cliente_nombre.required' => 'Información Requerida',
            'cliente_celular.required' => 'Información Requerida',
        ];

        $this->validate($rules, $messages);

        $newclient = Cliente::create([
            'nombre' => $this->cliente_nombre,
            'cedula' => $this->cliente_ci,
            'celular' => $this->cliente_celular,
            'procedencia_cliente_id' => 1,
        ]);
        $this->cliente_id = $newclient->id;
        $this->mensaje_toast = "Se selecciono al cliente creado: '" . $newclient->nombre . "'";
        //Ocultando ventana modal
        $this->emit('hide-crearcliente');
    }

    //Cierra la ventana modal Buscar Cliente y Cambiar el id de la variable $cliente_id
    public function seleccionarcliente($idcliente)
    {
        $this->cliente_id = $idcliente;
        $nombrecliente = Cliente::find($idcliente)->nombre;
        $celularcliente = Cliente::find($idcliente)->celular;
        $this->mensaje_toast = "Se seleccionó al cliente: '" . ucwords(strtolower($nombrecliente)) . "' para esta venta";
        $this->emit('hide-buscarcliente');
    }
    
}
