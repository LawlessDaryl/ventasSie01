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

class FreeSaleController extends Component
{
    //Datos para guardar una venta FreeFire
    public $nameclient, $phone, $idgame, $alias, $freeplan_id, $cryptocurrencies;

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

    public $nombrecliente;


    public function mount()
    {
        $this->cliente_id = 0;
    }


    public function render()
    {


        //Lista a todos los clientes que tengan el nombre de la variable $this->buscarcliente
        $listaclientes = [];
        if(strlen($this->buscarcliente) > 0)
        {
            $listaclientes = Cliente::select("clientes.*")
            ->where('clientes.nombre', 'like', '%' . $this->buscarcliente . '%')
            ->orderBy("clientes.created_at","desc")
            ->get();
        }


        if($this->cliente_id > 0)
        {
            $this->nombrecliente = Cliente::find($this->cliente_id)->nombre;
        }
        else
        {
            $this->nombrecliente = "Seleccione Cliente";
        }





        return view('livewire.freesale.freesale', [
            'listplans' => FreePlans::all(),
            'listsales' => FreeSale::all(),
            'carteras' => Cartera::all(),
            'listaclientes' => $listaclientes
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    public function showmodalnewsale()
    {
        $this->emit('show-modal-sale');
    }
    public function savesale()
    {
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
                'phone'=>$this->phone,
                'idaccount'=>$this->idgame,
                'alias'=> $this->alias,
                'observation'=> "Ninguna",
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
        ];
        $messages = [
            'cliente_nombre.required' => 'Información Requerida',
        ];
        $this->validate($rules, $messages);
        if($this->cliente_celular == null)
        {
            $newclient = Cliente::create([
                'nombre' => $this->cliente_nombre,
                'cedula' => $this->cliente_ci,
                'celular' => 0,
                // 'telefono' => $this->telefono,
                // 'email' => $this->email,
                // 'nit' => $this->nit,
                // 'razon_social' => $this->razon_social,
                'procedencia_cliente_id' => 1,
            ]);
        }
        else
        {
            $newclient = Cliente::create([
                'nombre' => $this->cliente_nombre,
                'cedula' => $this->cliente_ci,
                'celular' => $this->cliente_celular,
                // 'telefono' => $this->telefono,
                // 'email' => $this->email,
                // 'nit' => $this->nit,
                // 'razon_social' => $this->razon_social,
                'procedencia_cliente_id' => 1,
        ]);
        }
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
        $this->mensaje_toast = "Se seleccionó al cliente: '" . ucwords(strtolower($nombrecliente)) . "' para esta venta";
        $this->emit('hide-buscarcliente');
    }
    
}
