<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermisos extends Component
{
    public $roles, $idrol = 0, $rol = [], $permission = [];

    public function mount() {
        $this->roles = Role::all();
    }

    public function render()
    {
        return view('livewire.roles-permisos');
    }
    
    public function updatedIdrol($value) {
        //dd($value);
        $role = Role::find($this->idrol);

        $this->rol['name'] = ($role) ? $role->name : null;

        //dd($role->getPermissionNames()->toArray());

        $this->permission = ($role) ? $role->getPermissionNames()->toArray() : null;

        //return $role->permissions()->get();
    }

    public function role() {
        /* $this->validate(request(), [
            'rolname' => ['required'],
            'permission' => ['required'],
        ]); */

        //dd($this->rol);

        if($this->idrol == 0) {
            $role = Role::create(['guard_name' => 'web','name' => $this->rol['name']]);
        } else {
            $role = Role::find($this->idrol);
            $role->name = $this->rol['name'];

            $role->save();
        }
        //dd($request->permission);
        //$permission = Permission::findByname(1); 

        // $role = Role::find($request->rolp);
        
        // $user->syncRoles($role);

        $role->syncPermissions($this->permission);

        //session()->flash('status', 'Operación exitosa.');
 
        //return redirect()->to('/users');
    }

}
