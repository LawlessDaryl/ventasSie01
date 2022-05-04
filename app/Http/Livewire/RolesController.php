<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\DB;

class RolesController extends Component
{
    use WithPagination;
    public $roleName, $search, $selected_id, $pageTitle, $componentName;
    private $pagination = 10;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Roles';
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $roles = Role::where('name', 'like', '%' . $this->search . '%')->paginate($this->pagination);
        } else {
            $roles = Role::select('roles.*', DB::raw('0 as usuarios'))->orderBy('name', 'asc')->paginate($this->pagination);
        }

        foreach ($roles as $value) {
            $usuarios = Role::join('model_has_roles as mhr', 'mhr.role_id', 'roles.id')
                ->join('users as u', 'mhr.model_id', 'u.id')
                ->where('roles.id', $value->id)
                ->get();                
            $value->usuarios = $usuarios->count();
        }

        return view('livewire.roles.component', [
            'data' => $roles,
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }
    
    public function Agregar()
    {
        $this->resetUI();
        $this->emit('show-modal', 'show modal!');
    }

    public function CreateRole()
    {
        $rules = ['roleName' => 'required|min:2|unique:roles,name'];

        $messages = [
            'roleName.required' => 'El nombre del rol es requerido',
            'roleName.unique' => 'El rol ya existe',
            'roleName.min' => 'El nombre del rol debe tener al menos 2 caracteres'
        ];

        $this->validate($rules, $messages);

        Role::create(['name' => $this->roleName]);

        $this->emit('item-added', 'Se registró el rol con éxito');
        $this->resetUI();
    }

    public function Edit(Role $role)
    {
        $this->selected_id = $role->id;
        $this->roleName = $role->name;

        $this->emit('show-modal', 'Show modal ');
    }

    public function UpdateRole()
    {
        $rules = ['roleName' => "required|min:2|unique:roles,name, {$this->selected_id}"];

        $messages = [
            'roleName.required' => 'El nombre del rol es requerido',
            'roleName.unique' => 'El rol ya existe',
            'roleName.min' => 'El nombre del rol debe tener al menos 2 caracteres'
        ];

        $this->validate($rules, $messages);

        $role = Role::find($this->selected_id);
        $role->name = $this->roleName;
        $role->save();

        $this->emit('item-update', 'Se actualizó el rol con éxito');
        $this->resetUI();
    }

    protected $listeners = ['deleteRow' => 'Destroy'];

    public function Destroy($id)
    {
        $permissionsCount = Role::find($id)->permissions->count();
        if ($permissionsCount > 0) {
            $this->emit('role-deleted', 'No se puede eliminar el Rol por que tiene permisos asociados');
            return;
        }

        Role::find($id)->delete();
        $this->emit('role-deleted', 'Se eliminó el rol con exito');
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
        $this->roleName = '';
        $this->search = '';
        $this->selected_id = 0;
        $this->resetValidation();
    }
}
