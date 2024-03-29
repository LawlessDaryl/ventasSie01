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

class UsersController extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $name, $phone, $email, $status, $image, $password, $selected_id, $fileLoaded, $profile,
        $sucursal_id, $fecha_inicio, $fechafin, $idsucursalUser, $details, $sucurid, $sucurname;
    public $pageTitle, $componentName, $search, $sucur;
    private $pagination = 5;

    public function paginationView()
    {
        return 'vendor.livewire.bootstrap';
    }

    public function mount()
    {
        $this->selected_id = 0;
        $this->fromDate = null;
        $this->toDate = null;
        $this->pageTitle = 'Listado';
        $this->componentName = 'Usuarios';
        $this->status = 'Elegir';
        $this->profile = 'Elegir';
        $this->sucursal_id = 'Elegir';
        $this->sucur = 'Elegir';
        $this->details = [];
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $data = User::join('sucursal_users as su', 'su.user_id', 'users.id')
                ->join('sucursals as s', 'su.sucursal_id', 's.id')
                ->select('users.*', 's.name as nombreEmpresa')
                ->whereNull('fecha_fin')
                ->where('users.name', 'like', '%' . $this->search . '%')
                ->orwhere('s.name', 'like', '%' . $this->search . '%')
                ->orderBy('users.name', 'asc')
                ->paginate($this->pagination);
        } else { /* MOSTRAR SUCURSAL_USER DE LOS USUARIOS CON FECHA_FIN NULL */
            $data = User::join('sucursal_users as su', 'su.user_id', 'users.id')
                ->join('sucursals as s', 'su.sucursal_id', 's.id')
                ->select('users.*', 's.name as nombreEmpresa')
                ->where('estado', 'ACTIVO')
                ->orderBy('name', 'asc')
                ->paginate($this->pagination);
        }
        /* lISTADO DE LAS SUCURSALES EN LAS CUALES ESTUVO EL USUARIO */
        $this->details = User::join('sucursal_users as su', 'su.user_id', 'users.id',)
            ->join('sucursals as s', 's.id', 'su.sucursal_id',)
            ->select('su.created_at', 'su.fecha_fin', 's.name')
            ->where('su.user_id', $this->selected_id)
            ->orderBy('su.id', 'desc')
            ->get();

        return view('livewire.users.component', [
            'data' => $data,
            'roles' => Role::orderBy('name', 'asc')->get(),
            'sucursales' => Sucursal::orderBy('name', 'asc')->get()
        ])
            ->extends('layouts.theme.app')
            ->section('content');
    }


    public function Store()
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|unique:users|email',
            'status' => 'required|not_in:Elegir',
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
            'status.required' => 'Selecciona el estatus del usuario',
            'status.not_in' => 'Seleccine un estado distinto a Elegir',
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
                'status' => $this->status,
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
    {   /* CARGAR LOS DATOS DEL USUARIO EN EL MODAL */
        $this->selected_id = $user->id;
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->profile = $user->profile;
        $this->status = $user->status;
        $this->email = $user->email;
        $this->password = '';

        $this->emit('show-modal', 'open!');
    }

    public function Update()
    {
        $rules = [
            'email' => "required|email|unique:users,email,{$this->selected_id}",
            'name' => 'required|min:3',
            'status' => 'required|not_in:Elegir',
            'profile' => 'required|not_in:Elegir',
            'password' => 'required|min:3',
        ];
        $messages = [
            'name.required' => 'Ingresa el nombre del usuario',
            'name.min' => 'El nombre del usuario debe tener al menos 3 caracteres',
            'email.required' => 'Ingresa una direccion de correo electrónico',
            'email.email' => 'Ingresa una dirección de correo válida',
            'email.unique' => 'El email ya existe en el sistema',
            'status.required' => 'Selecciona el estatus del usuario',
            'status.not_in' => 'Seleccine un estado distinto a Elegir',
            'profile.required' => 'Selecciona el perfil/rol del usuario',
            'profile.not_in' => 'Seleccioa un perfil/rol distinto a Elegir',
            'password.required' => 'Ingresa el password',
            'password.min' => 'El password debe tener al menos 3 caracteres',
        ];
        $this->validate($rules, $messages);

        $user = User::find($this->selected_id);
        /* EDITAR DATOS DEL USUARIO */
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'profile' => $this->profile,
            'password' => bcrypt($this->password)
        ]);
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
    {   /*  */
        if ($user) {
            $sales = Sale::where('user_id', $user->id)->count();
            $transaccions = Transaccion::where('user_id', $user->id)->count();
            if ($sales > 0 || $transaccions > 0) {
                $this->emit('user-withsales', 'No es posible eliminar el usuario porque tiene ventas o transacciones registradas');
            } else {
                $user->delete();

                $imageName = $user->image;

                if ($imageName != null) {
                    unlink('storage/usuarios/' . $imageName);
                }

                $this->resetUI();
                $this->emit('item-deleted', 'Usuario Eliminado');
            }
        }
    }
    /* VENTANA MODAL DE HISTORIAL DEL USUARIO */
    public function viewDetails(User $u)
    {
        $this->selected_id = $u->id;
        /* OBTENER SUCURSAL-USER DEL USUARIO SELECCIONADO */
        $idsu = User::join('sucursal_users as su', 'su.user_id', 'users.id')
            ->join('sucursals as s', 'su.sucursal_id', 's.id')
            ->where('su.user_id', $u->id)
            ->select('s.id as sucursalid', 's.name as sucursalname', 'su.id as sucursalUID')
            ->orderBy('su.id', 'desc')
            ->first();
        $this->idsucursalUser = $idsu->sucursalUID;
        $this->sucurid = $idsu->sucursalid;
        $this->sucurname = $idsu->sucursalname;
        $this->sucur = $this->sucurid;

        $this->emit('show-modal2', 'open modal');
    }
    /* CAMBIAR DE SUCURSAL AL USUARIO */
    public function Cambiar()
    {
        $DateAndTime = date('Y-m-d H:i:s', time());
        if ($this->sucur != 'Elegir') {
            if ($this->sucur != $this->sucurid) {
                /* CREAR NUEVO SUCURSAL_USER */
                SucursalUser::create([
                    'user_id' => $this->selected_id,
                    'sucursal_id' => $this->sucur,
                    'estado' => 'ACTIVO',
                    'fecha_fin' => null,
                ]);
                /* EDITAR ANTERIOR SUCURSAL_USER, PONIENDO FECHA FIN O NO SEGUN EL CASO */
                $su = SucursalUser::find($this->idsucursalUser);
                if ($su->fecha_fin == null) {
                    $su->update([
                        'estado' => 'FINALIZADO',
                        'fecha_fin' => $DateAndTime
                    ]);
                }else{
                    $su->update([
                        'estado' => 'FINALIZADO'
                    ]);
                }
                $this->emit('sucursal-actualizada', 'Se cambio al usuario de sucursal');
            }
        }
    }
    public function finalizar()
    {
        $DateAndTime = date('Y-m-d H:i:s', time());

        $su = SucursalUser::find($this->idsucursalUser);
        $su->update([
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
        $this->fecha_inicio = '';
        $this->fecha_fin = '';
        $this->status = 'Elegir';
        $this->profile = 'Elegir';
        $this->sucursal_id = 'Elegir';
        $this->selected_id = 0;
        $this->search = '';
        $this->resetValidation();
        $this->resetPage();
    }
}
