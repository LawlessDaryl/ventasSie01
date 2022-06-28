<?php

namespace App\Http\Livewire;

use App\Models\StrSupplier;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class StrProveedorController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $name, $phone, $mail, $address, $status, $image, $selected_id;
    public $pageTitle, $componentName, $search;
    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->selected_id = 0;
        $this->pageTitle = 'Listado';
        $this->componentName = 'Proveedores Streaming';
        $this->name = '';
        $this->phone = '';
        $this->mail = '';
        $this->address = '';
        $this->status = 'ACTIVO';
    }

    public function render()
    {
        if (strlen($this->search) > 0)
            $data = StrSupplier::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('phone', 'like', '%' . $this->search . '%')
                ->orWhere('mail', 'like', '%' . $this->search . '%')
                ->orWhere('status', 'like', '%' . $this->search . '%')
                ->paginate($this->pagination);
        else
            $data = StrSupplier::orderBy('id', 'desc')->paginate($this->pagination);


        return view('livewire.str_proveedor.component', [
            'data' => $data,
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
            'name' => 'required|min:3',
            'phone' => 'required|min:3',
            'mail' => 'required|unique:str_suppliers|email',
            'status' => 'required'
        ];

        $messages = [
            'name.required' => 'Ingresa el nombre del proveedor',
            'name.min' => 'El nombre del proveedor debe tener al menos 3 caracteres',
            'phone.required' => 'Ingresa el número de contácto del proveedor',
            'phone.min' => 'El número de contácto debe tener al menos 3 caracteres',
            'mail.required' => 'Ingresa una direccion de correo electrónico',
            'mail.email' => 'Ingresa una dirección de correo válida',
            'mail.unique' => 'El email ya existe en el sistema',
            'status.required' => 'Selecciona el estado del proveedor',
        ];

        $this->validate($rules, $messages);

        $supplier = StrSupplier::create([
            'name' => $this->name,
            'phone' => $this->phone,
            'mail' => $this->mail,
            'address' => $this->address,
            'status' => $this->status
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/proveedores', $customFileName);
            $supplier->image = $customFileName;
            $supplier->save();
        } else {
            $supplier->image = 'noimage.jpg';
            $supplier->save();
        }

        $this->resetUI();
        $this->emit('item-added', 'Proveedor Registrado');
    }

    public function Edit(StrSupplier $supl)
    {
        $this->selected_id = $supl->id;
        $this->name = $supl->name;
        $this->phone = $supl->phone;
        $this->mail = $supl->mail;
        $this->address = $supl->addres;
        $this->status = $supl->status;

        $this->emit('show-modal', 'open!');
    }

    public function Update()
    {
        $rules = [
            'name' => 'required|min:3',
            'phone' => 'required|min:3',
            'mail' => "required|email|unique:str_suppliers,mail,{$this->selected_id}",
            'status' => 'required'
        ];

        $messages = [
            'name.required' => 'Ingresa el nombre del proveedor',
            'name.min' => 'El nombre del proveedor debe tener al menos 3 caracteres',
            'phone.required' => 'Ingresa el número de contácto del proveedor',
            'phone.min' => 'El número de contácto debe tener al menos 3 caracteres',
            'mail.required' => 'Ingresa una direccion de correo electrónico',
            'mail.email' => 'Ingresa una dirección de correo válida',
            'mail.unique' => 'El email ya existe en el sistema',
            'status.required' => 'Selecciona el estado del proveedor',
        ];

        $this->validate($rules, $messages);

        $supl = StrSupplier::find($this->selected_id);

        $supl->update([
            'name' => $this->name,
            'phone' => $this->phone,
            'mail' => $this->mail,
            'address' => $this->address,
            'status' => $this->status
        ]);

        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/proveedores', $customFileName);
            $imageTemp = $supl->image;

            $supl->image = $customFileName;
            $supl->save();

            if ($imageTemp != null) {
                if (file_exists('storage/proveedores/' . $imageTemp)) {
                    unlink('storage/proveedores/' . $imageTemp);
                }
            }
        }

        $this->resetUI();
        $this->emit('item-updated', 'Proveedor Actualizado');
    }

    protected $listeners = ['deleteRow' => 'destroy', 'resetUI' => 'resetUI'];

    public function destroy(StrSupplier $supl)
    {
        $imageTemp = $supl->image;
        $supl->delete();

        if ($imageTemp != null) {
            if (file_exists('storage/proveedores/' . $imageTemp)) {
                unlink('storage/proveedores/' . $imageTemp);
            }
        }
        $this->resetUI();
        $this->emit('item-deleted', 'Proveedor Eliminado');
    }
    /* VENTANA MODAL DE HISTORIAL DE contratos con el proveedor */
    /* public function viewDetails(StrSupplier $s)
    {
        $this->selected_id = $s->id;

        $this->contr = StrSupplier::join('supl_platforms as pp', 'pp.str_supplier_id', 'str_suppliers.id')
            ->join('platforms as p', 'p.id', 'pp.platform_id')
            ->where('pp.str_supplier_id', $s->id)
            ->select('p.id as platformid', 'p.nombre as platformname', 'pp.id as provplatformid', 'pp.created_at as provplatformdate')
            ->orderBy('pp.id', 'desc')
            ->get();

        if ($this->contr == null) {
            $this->contract_id = $this->contr->provplatformid;
            $this->platform_id = $this->contr->platformid;
            $this->plataformname = $this->contr->platformname;
            $this->contract_date = $this->contr->provplatformdate;
            $this->platform = $this->platform_id;

            $this->emit('show-modal2', 'open modal');
        } else {
            $this->emit('item-error', 'Proveedor no tiene historial de contratos');
        }
    } */
    public function resetUI()
    {
        $this->name = '';
        $this->phone = '';
        $this->mail = '';
        $this->address = '';
        $this->status = 'ACTIVO';
        $this->image = '';
        $this->selected_id = 0;
        $this->search = '';
        $this->resetValidation();
        $this->resetPage();
    }
}
