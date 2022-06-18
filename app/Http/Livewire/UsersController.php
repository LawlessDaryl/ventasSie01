<?php

namespace App\Http\Livewire;

use App\Models\Sale;
use App\Models\Sucursal;
use App\Models\SucursalUser;
use App\Models\Transaccion;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;

class UsersController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $name, $phone, $email, $image, $password, $selected_id, $fileLoaded, $profile,
        $sucursal_id, $fecha_inicio, $fechafin, $idsucursalUser, $details, $sucurid, $sucurname;
    public $pageTitle, $componentName, $search, $sucur;
    private $pagination = 10;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->pageTitle = 'Listado';
        $this->componentName = 'Usuarios';
        $this->selected_id = 0;
        $this->profile = 'Elegir';
        $this->sucursal_id = 'Elegir';
        $this->sucursalUsuario = 'Elegir';
        $this->sucursalUserUsuario = '';
        $this->usuarioACTIVO = '';
        $this->details = [];
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = User::where('name', 'like', '%' . $this->search . '%')
                ->orderBy('name', 'asc')
                ->paginate($this->pagination);
        } else {
            $data = User::orderBy('name', 'asc')
                ->paginate($this->pagination);
        }

        if ($this->selected_id > 0) {
            $this->details = User::join('sucursal_users as su', 'users.id', 'su.user_id')
                ->join('sucursals as s', 's.id', 'su.sucursal_id')
                ->select('su.created_at', 'su.fecha_fin', 's.name')
                ->where('users.id', $this->selected_id)
                ->orderBy('su.created_at', 'desc')
                ->get();
        }


        return view('livewire.users.component', [
            'data' => $data,
            'roles' => Role::orderBy('name', 'asc')->get(),
            'sucursales' => Sucursal::orderBy('name', 'asc')->get()
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
            'email' => 'required|unique:users|email',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:3',
            'sucursal_id' => 'required|not_in:Elegir',
        ];
        $messages = [
            'name.required' => 'Ingresa el nombre del usuario',
            'name.min' => 'El nombre del usuario debe tener al menos 3 caracteres',
            'email.required' => 'Ingresa una direccion de correo electrónico',
            'email.email' => 'Ingresa una dirección de correo válida',
            'email.unique' => 'El email ya existe en el sistema',
            'profile.required' => 'Selecciona el perfil/rol del usuario',
            'profile.not_in' => 'Seleccioa un perfil/rol distinto a Elegir',
            'password.required' => 'Ingresa el password',
            'password.min' => 'El password debe tener al menos 3 caracteres',
            'sucursal_id.required' => 'Seleccione la sucursal del usuario',
            'sucursal_id.not_in' => 'Seleccione una sucursal distinto a Elegir',
        ];
        $this->validate($rules, $messages);

        DB::beginTransaction();
        try {   /* REGISTRO DEL USUARIO "DOS TABLAS" */

            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'status' => 'ACTIVE',
                'profile' => $this->profile,
                'password' => bcrypt($this->password)
            ]);

            $user->syncRoles($this->profile);

            if ($this->image) {
                $customFileName = uniqid() . '_.' . $this->image->extension();
                $this->image->storeAs('public/usuarios', $customFileName);
                $user->image = $customFileName;
                $user->save();
            }

            SucursalUser::create([
                'user_id' => $user->id,
                'sucursal_id' => $this->sucursal_id,
                'estado' => 'ACTIVO',
                'fecha_fin' => null,
            ]);

            DB::commit();
            $this->resetUI();
            $this->emit('item-added', 'Usuario Registrado');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'No se pudo crear el usuario ' . $e->getMessage());
        }
    }

    public function Edit(User $user)
    {
        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->profile = $user->profile;
        $this->email = $user->email;
        $this->password = '';

        $this->emit('show-modal', 'open!');
    }

    public function Update()
    {
        $rules = [
            'email' => "required|email|unique:users,email,{$this->selected_id}",
            'name' => 'required|min:3',
            'profile' => 'required|not_in:Elegir',
            'password' => 'nullable|min:3',
        ];
        $messages = [
            'name.required' => 'Ingresa el nombre del usuario',
            'name.min' => 'El nombre del usuario debe tener al menos 3 caracteres',
            'email.required' => 'Ingresa una direccion de correo electrónico',
            'email.email' => 'Ingresa una dirección de correo válida',
            'email.unique' => 'El email ya existe en el sistema',
            'profile.required' => 'Selecciona el perfil/rol del usuario',
            'profile.not_in' => 'Seleccioa un perfil/rol distinto a Elegir',
            'password.min' => 'El password debe tener al menos 3 caracteres',
        ];
        $this->validate($rules, $messages);

        $user = User::find($this->selected_id);
        if ($this->password != null) {
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'profile' => $this->profile,
                'password' => bcrypt($this->password)
            ]);
        } else {
            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'profile' => $this->profile
            ]);
        }
        $user->syncRoles($this->profile);
        if ($this->image) {
            $customFileName = uniqid() . '_.' . $this->image->extension();
            $this->image->storeAs('public/usuarios', $customFileName);
            $imageTemp = $user->image;

            $user->image = $customFileName;
            $user->save();

            if ($imageTemp != null) {
                if (file_exists('storage/categorias/' . $imageTemp)) {
                    unlink('storage/categorias/' . $imageTemp);
                }
            }
        }

        $this->resetUI();
        $this->emit('item-updated', 'Usuario Actualizado');
    }

    protected $listeners = [
        'deleteRow' => 'destroy',
        'resetUI' => 'resetUI'
    ];

    public function destroy(User $user)
    {
        $eliminarSucUsers = SucursalUser::join('users as u', 'u.id', 'sucursal_users.user_id')
            ->select('sucursal_users.*')
            ->where('u.id', $user->id)
            ->get();

        foreach ($eliminarSucUsers as $value) {
            $value->delete();
        }

        $user->delete();

        $imageName = $user->image;

        if ($imageName != null) {
            unlink('storage/usuarios/' . $imageName);
        }

        $this->resetUI();
        $this->emit('item-deleted', 'Usuario Eliminado');
    }
    /* VENTANA MODAL DE HISTORIAL DEL USUARIO */
    public function viewDetails(User $user)
    {
        $this->selected_id = $user->id;

        if ($user->status == 'ACTIVE') {
            $this->usuarioACTIVO = 'SI';
        } else {
            $this->usuarioACTIVO = 'NO';
        }

        foreach ($user->sucursalusers as $value) {
            if ($value->estado == 'ACTIVO') {
                $this->sucurname = $value->sucursal->name;
                $this->sucursalUserUsuario = $value->id;
                /* variable para comparar si cambio en el combobox */
                $this->sucursalDelUsuario = $value->sucursal->id;
                /* esta de abajo cambia en el modal */
                $this->sucursalUsuario = $value->sucursal->id;
            }
        }
        if ($this->sucursalUserUsuario == '') {
            $this->sucursalUsuario = '1';
        }

        $this->emit('show-modal2', 'open modal');
    }
    /* CAMBIAR DE SUCURSAL AL USUARIO */
    public function Cambiar()
    {
        $DateAndTime = date('Y-m-d H:i:s', time());
        DB::beginTransaction();
        try {
            if ($this->sucursalUsuario != $this->sucursalDelUsuario) {
                /* CREAR NUEVO SUCURSAL_USER */
                SucursalUser::create([
                    'user_id' => $this->selected_id,
                    'sucursal_id' => $this->sucursalUsuario,
                    'estado' => 'ACTIVO',
                    'fecha_fin' => null,
                ]);

                /* EDITAR ANTERIOR SUCURSAL_USER, PONIENDO FECHA FIN O NO SEGUN EL CASO */
                $su = SucursalUser::find($this->sucursalUserUsuario);
                if ($su->fecha_fin == null) {
                    $su->update([
                        'estado' => 'FINALIZADO',
                        'fecha_fin' => $DateAndTime
                    ]);
                }

                $usuario = User::find($this->selected_id);
                $usuario->update([
                    'status' => 'ACTIVE',
                ]);
                $usuario->save();
            }
            DB::commit();
            $this->resetUI();
            $this->emit('sucursal-actualizada', 'Se cambió al usuario de sucursal');
        } catch (Exception $e) {
            DB::rollback();
            $this->emit('item-error', 'El usuario ya fue cambiado');
        }
    }
    public function Activar()
    {
        SucursalUser::create([
            'user_id' => $this->selected_id,
            'sucursal_id' => $this->sucursalUsuario,
            'estado' => 'ACTIVO',
            'fecha_fin' => null,
        ]);
        $usuario = User::find($this->selected_id);
        $usuario->update([
            'status' => 'ACTIVE',
        ]);
        $usuario->save();
        $this->emit('user-fin', 'El usuario ahora esta activo, registre una nueva contraseña para el usuario');
    }
    public function finalizar()
    {
        $DateAndTime = date('Y-m-d H:i:s', time());

        $usuario = User::find($this->selected_id);
        $usuario->update([
            'status' => 'LOCKED',
            'password' => bcrypt(uniqid()),
        ]);
        $usuario->save();

        $su = SucursalUser::find($this->sucursalUserUsuario);
        $su->update([
            'estado' => 'FINALIZADO',
            'fecha_fin' => $DateAndTime
        ]);
        $this->emit('user-fin', 'Termino el ciclo del usuario');
    }

    public function resetUI()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->phone = '';
        $this->image = '';

        $this->selected_id = 0;
        $this->profile = 'Elegir';
        $this->sucursal_id = 'Elegir';
        $this->sucursalUsuario = '';
        $this->sucursalUserUsuario = '';
        $this->details = [];
        $this->usuarioACTIVO = '';

        $this->resetValidation();
        $this->resetPage();
    }
}
