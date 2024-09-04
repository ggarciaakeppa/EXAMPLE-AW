<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class usersModal extends Component
{
    public $roles;

    public $userModalData;

    public $idrol = 0;

    protected $messages = [
        'userModalData.name.required' => 'El nombre no puede ir vacio.',
        'userModalData.last_name.required' => 'Los apellidos no pueden ir vacios.',
        'userModalData.phone.required' => 'Deberia haber un medio de contacto',
        'userModalData.email.required' => 'El correo no puede ir vacio.',
        'userModalData.email.email' => 'El formato de correo no es valido',
        'userModalData.email.unique' => 'El correo ya esta en uso',
    ];

    protected function rules()
    {
        return [
            'idrol' => 'required',
            'userModalData.phone' => 'required|max:255',
            'userModalData.name' => 'required|string|max:255',
            'userModalData.last_name' => 'required|string|max:255',
            'userModalData.email' => 'required|string|email|max:255|unique:users,email',
        ];
    }

    public function mount() {
        $this->roles = Role::all();
    }

    public function render()
    {
        return view('livewire.users-modal');
    }

    public function createUser() {
        $this->validate();

        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        $user = User::create([
            'name' => $this->userModalData['name'],
            'last_name' => $this->userModalData['last_name'],
            'phone' => $this->userModalData['phone'],
            'email' => $this->userModalData['email'],
            'status' => 1,
            'password' => Hash::make(implode($pass)),
        ]);

        if($this->idrol != 0) {

            $user->syncRoles($this->idrol);

        }

        $status = Password::sendResetLink([
            'email' => $this->userModalData['email']
        ]);
     
        $status === Password::RESET_LINK_SENT;

        session()->flash('status', 'Usuario creado con exito!');
 
        return redirect()->to('/users');
    }

}
