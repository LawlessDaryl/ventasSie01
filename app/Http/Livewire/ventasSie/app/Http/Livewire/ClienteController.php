<?php

namespace App\Http\Livewire;

use App\Models\Cliente;
use App\Models\Origen;
use App\Models\ProcedenciaCliente;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ClienteController extends Component
{
    use WithPagination;
    use WithFileUploads;
    public  $search, $nombre, $cedula, $celular, $direccion, $email, $fnacim, $razonsocial, $nit, $procedencia, $selected_id, $image;
    public  $pageTitle, $componentName;
    private $pagination = 12;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Cliente';
        $this->procedencia = 'Nuevo';
        $this->selected_id = 0;
        $this->nombre = '';
        $this->direccion = '';
        $this->email = '';
        $this->razonsocial = '';
        $this->image = '';
    }

    public function render()
    {
        if (strlen($this->search) > 0)
            $cliente = Cliente::join('procedencia_clientes as pc', 'clientes.procedencia_cliente_id', 'pc.id')
                ->select('clientes.*', 'pc.procedencia as procedencia')
                ->where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('cedula', 'like', '%' . $this->search . '%')
                ->orWhere('celular', 'like', '%' . $this->search . '%')
                ->orWhere('nit', 'like', '%' . $this->search . '%')
                ->orWhere('procedencia', 'like', '%' . $this->search . '%')
                ->orderBy('id', 'desc')
                ->paginate($this->pagination);
        else
            $cliente = Cliente::join('procedencia_clientes as pc', 'clientes.procedencia_cliente_id', 'pc.id')
                ->select('clientes.*', 'pc.procedencia as procedencia')
                ->orderBy('id', 'desc')
                ->paginate($this->pagination);
        return view('livewire.cliente.component', [
            'data' => $cliente,
            'procedenciaClientes' => ProcedenciaCliente::orderBy('id', 'asc')->get()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }

    public function Agregar()
    {
        $this->resetUI();
        $this->emit('show-modal', 'show modal!');
    }
    
    public function Store()
    {
        $rules = [
            'nombre' => 'required',
            'cedula' => 'required|min:5,unique|unique:clientes',
            'celular' => 'required|min:8',
        ];
        $messages = [
            'nombre.required' => 'El nombre es requerido.',
            'cedula.required' => 'Numero de cédula es requerido.',
            'cedula.min' => 'Ingrese un numero de cédula superior a 5 dígitos.',
            'cedula.unique' => 'El CI ya existe',
            'celular.required' => 'Numero de celular es requerido.',
            'celular.min' => 'Ingrese un celular superior a 7 dígitos.',
        ];
        $this->validate($rules, $messages);

        if ($this->procedencia == 'Nuevo') {
            $procd = ProcedenciaCliente::where('procedencia', 'Nuevo')->get()->first();
            Cliente::create([
                'nombre' => $this->nombre,
                'cedula' => $this->cedula,
                'celular' => $this->celular,
                'direccion' => $this->direccion,
                'email' => $this->email,
                'fecha_nacim' => $this->fnacim,
                'razon_social' => $this->razonsocial,
                'nit' => $this->nit,
                'procedencia_cliente_id' => $procd->id,
            ]);
        } else {
            Cliente::create([
                'nombre' => $this->nombre,
                'cedula' => $this->cedula,
                'celular' => $this->celular,
                'direccion' => $this->direccion,
                'email' => $this->email,
                'fecha_nacim' => $this->fnacim,
                'razon_social' => $this->razonsocial,
                'nit' => $this->nit,
                'procedencia_cliente_id' => $this->procedencia,
            ]);
        }

        $this->resetUI();
        $this->emit('item-added', 'Cliente Registrado');
    }

    public function Edit(Cliente $cli)
    {
        $this->selected_id = $cli->id;
        $this->nombre = $cli->nombre;
        $this->cedula = $cli->cedula;
        $this->celular = $cli->celular;
        $this->email = $cli->email;
        $this->fnacim = $cli->fecha_nacim;
        $this->nit = $cli->nit;
        $this->direccion = $cli->direccion;
        $this->razonsocial = $cli->razon_social;
        $this->procedencia = $cli->procedencia_cliente_id;

        $this->emit('show-modal', 'show modal!');
    }

    public function Update()
    {
        $rules = [
            'cedula' => "required|min:5|unique:clientes,cedula,{$this->selected_id}",
            'celular' => 'required|min:8',
            'nit' => 'required'
        ];
        $messages = [
            'cedula.required' => 'Numero de cédula es requerido.',
            'cedula.min' => 'Ingrese un numero de cédula superior a 5 dígitos.',
            'cedula.unique' => 'El CI ya existe',
            'celular.required' => 'Numero de celular es requerido.',
            'celular.min' => 'Ingrese un celular superior a 7 dígitos.',
            'nit.required' => 'El Nit es requerido'
        ];
        $this->validate($rules, $messages);

        $cliente = Cliente::find($this->selected_id);
        if ($this->procedencia == 'Nuevo') {
            $procd = ProcedenciaCliente::where('procedencia', 'Nuevo')->get()->first();

            $cliente->update([
                'nombre' => $this->nombre,
                'cedula' => $this->cedula,
                'celular' => $this->celular,
                'direccion' => $this->direccion,
                'email' => $this->email,
                'fecha_nacim' => $this->fnacim,
                'razon_social' => $this->razonsocial,
                'nit' => $this->nit,
                'procedencia_cliente_id' => $procd->id
            ]);
        } else {
            $cliente->update([
                'nombre' => $this->nombre,
                'cedula' => $this->cedula,
                'celular' => $this->celular,
                'direccion' => $this->direccion,
                'email' => $this->email,
                'fecha_nacim' => $this->fnacim,
                'razon_social' => $this->razonsocial,
                'nit' => $this->nit,
                'procedencia_cliente_id' => $this->procedencia
            ]);
        }

        $this->resetUI();
        $this->emit('item-updated', 'Cliente Actualizado');
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy(Cliente $cli)
    {
        $cli->delete();
        $this->resetUI();
        $this->emit('item-deleted', 'Cliente Eliminado');
    }

    public function resetUI()
    {
        $this->selected_id = 0;
        $this->nombre = '';
        $this->cedula = '';
        $this->celular = '';
        $this->email = '';
        $this->fnacim = '';
        $this->reset(['nit']);
        $this->procedencia = 'Nuevo';
        $this->direccion = '';
        $this->razonsocial = '';
        $this->resetValidation();
    }
}
