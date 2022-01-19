<?php

namespace App\Http\Livewire;

use App\Models\StrSupplier;
use App\Models\SuplPlatform;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class StrProveedorController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $name, $phone, $mail, $address, $status, $image, $selected_id, $fileLoaded, $profile;
    public $pageTitle, $componentName, $search, $hora;
    public $contract_id, $platform_id, $plataformname, $platform, $contract_date, $contr=[];

    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->selected_id = 0;
        $this->hora = date("d-m-y H:i:s ");
        $this->pageTitle = 'Listado';
        $this->componentName = 'Proveedores Streaming';
        $this->status = 'Elegir';
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
        

        return view('livewire.str_proveedor.component', [ 'data' => $data ])
            ->extends('layouts.theme.app')
            ->section('content');
    }


    public function Store()
    {
        $rules = [
            'name' => 'required|min:3',
            'phone' => 'required|min:3',
            'mail' => 'required|unique:str_suppliers|email',
            'status' => 'required|not_in:Elegir'
        ];

        $messages = [
            'name.required' => 'Ingresa el nombre del proveedor',
            'name.min' => 'El nombre del proveedor debe tener al menos 3 caracteres',
            'phone.required' => 'Ingresa el numero de contácto del proveedor',
            'phone.min' => 'El numero de contácto debe tener al menos 3 caracteres',
            'mail.required' => 'Ingresa una direccion de correo electrónico',
            'mail.email' => 'Ingresa una dirección de correo válida',
            'mail.unique' => 'El email ya existe en el sistema',
            'status.required' => 'Selecciona el estado del proveedor',
            'status.not_in' => 'Seleccine un estado distinto a Elegir',
        ];

        $this->validate($rules, $messages);

        DB::beginTransaction();
        try {
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
            }

            DB::commit();
            $this->resetUI();
            $this->emit('item-added', 'Proveedor Registrado');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'No se pudo crear el proveedor ' . $e->getMessage());
        }
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
            'mail' => 'required|email|unique:str_suppliers',
            'status' => 'required|not_in:Elegir'
        ];

        $messages = [
            'name.required' => 'Ingresa el nombre del proveedor',
            'name.min' => 'El nombre del proveedor debe tener al menos 3 caracteres',
            'phone.required' => 'Ingresa el numero de contácto del proveedor',
            'phone.min' => 'El numero de contácto debe tener al menos 3 caracteres',
            'mail.required' => 'Ingresa una direccion de correo electrónico',
            'mail.email' => 'Ingresa una dirección de correo válida',
            'mail.unique' => 'El email ya existe en el sistema',
            'status.required' => 'Selecciona el estado del proveedor',
            'status.not_in' => 'Seleccine un estado distinto a Elegir',
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

    protected $listeners = [
        'deleteRow' => 'destroy',
        'resetUI' => 'resetUI'
    ];

    public function destroy(StrSupplier $supl)
    {

        if ($supl) {
            $contrato = SuplPlatform ::where('id_supplier', $supl->id)->count();
            if ($contrato > 0 ) {
                $this->emit('supplier-withcontracts', 'No es posible eliminar el proveedor porque tiene plataformas asosiadas');
            } else {
                $supl->delete();

                $imageName = $supl->image;

                if ($imageName != null) {
                    unlink('storage/proveedores/' . $imageName);
                }

                $this->resetUI();
                $this->emit('item-deleted', 'Proveedor Eliminado');
            }
        }
    }
    /* VENTANA MODAL DE HISTORIAL DE contratos con el proveedor */
    public function viewDetails(StrSupplier $s)
    {
        $this->selected_id = $s->id;
               
        $this->contr = StrSupplier::join('supl_platforms as pp', 'pp.str_supplier_id', 'str_suppliers.id')
            ->join('platforms as p', 'p.id', 'pp.platform_id')
            ->where('pp.str_supplier_id', $s->id)
            ->select('p.id as platformid', 'p.nombre as platformname', 'pp.id as provplatformid', 'pp.created_at as provplatformdate')
            ->orderBy('pp.id', 'desc')
            ->get();

        if($this->contr == null)
        {
            $this->contract_id = $this->contr->provplatformid;
        $this->platform_id = $this->contr->platformid;
        $this->plataformname = $this->contr->platformname;
        $this->contract_date = $this->contr->provplatformdate;
        $this->platform = $this->platform_id;

        $this->emit('show-modal2', 'open modal');
        } else{
            $this->emit('item-error', 'Proveedor no tiene historial de contratos');
        }

        
        
    }
    public function resetUI()
    {
        $this->name = '';
        $this->phone = '';
        $this->mail = '';
        $this->address = '';
        $this->status = 'Elegir';
        $this->image = '';
        $this->selected_id = 0;
        $this->search = '';
        $this->resetValidation();
        $this->resetPage();
    }
}
