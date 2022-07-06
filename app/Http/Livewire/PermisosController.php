<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use App\Models\User;

class PermisosController extends Component
{
    use WithPagination;
    public $permissionName,$permissionArea,$permissionDescripcion, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 20;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Permisos';
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $permisos = Permission::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        } else {
            $permisos = Permission::orderBy('name', 'asc')->paginate($this->pagination);
        }
        return view('livewire.permisos.component', [
            'data' => $permisos,
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    
    public function Agregar()
    {
        $this->resetUI();
        $this->emit('show-modal', 'show modal!');
    }

    public function CreatePermission()
    {
        $rules = ['permissionName' => 'required|min:2|unique:permissions,name'];

        $messages = [
            'permissionName.required' => 'El nombre del permiso es requerido',
            'permissionName.unique' => 'El permiso ya existe',
            'permissionName.min' => 'El nombre del permiso debe tener al menos 2 caracteres'
        ];

        $this->validate($rules, $messages);

        Permission::create(['name' => $this->permissionName,'area' => $this->permissionArea,'descripcion' => $this->permissionDescripcion]);

        $this->emit('item-added', 'Se registró el permiso con éxito');
        $this->resetUI();
    }

    public function Edit(Permission $permiso)
    {
        $this->selected_id = $permiso->id;
        $this->permissionName = $permiso->name;
        $this->permissionArea = $permiso->area;
        $this->permissionDescripcion = $permiso->descripcion;

        $this->emit('show-modal', 'Show modal ');
    }

    public function UpdatePermission()
    {
        $rules = ['permissionName' => "required|min:2|unique:permissions,name, {$this->selected_id}"];

        $messages = [
            'permissionName.required' => 'El nombre del permiso es requerido',
            'permissionName.unique' => 'El permiso ya existe',
            'permissionName.min' => 'El nombre del permiso debe tener al menos 2 caracteres'
        ];

        $this->validate($rules, $messages);

        $role = Permission::find($this->selected_id);
        $role->name = $this->permissionName;
        $role->area = $this->permissionArea;
        $role->descripcion = $this->permissionDescripcion;
        $role->save();

        $this->emit('item-update', 'Se actualizó el permiso con éxito');
        $this->resetUI();
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy($id)
    {
        $rolesCount = Permission::find($id)->getRoleNames()->count();

        if ($rolesCount > 0) {
            $this->emit('item-error', 'No se puede eliminar el permiso por que tiene roles asociados');
            return;
        }

        Permission::find($id)->delete();
        $this->emit('item-deleted', 'Se eliminó el permiso con exito');
    }

    //poner en el componente users

    /* public function AisgnarRoles($rolesList)
    {
        if($this->userSelected > 0)
        {
            $user = User::find($this->userSelected);
            if($user)
            {
                $user->syncRoles($rolesList);
                $this->emit('msg-ok', 'Roles asignados correctamente');
                $this->resetInput();  
            } 
        }
    } */

    public function resetUI()
    {
        $this->permissionName = '';
        $this->permissionArea = '';
        $this->permissionDescripcion = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
