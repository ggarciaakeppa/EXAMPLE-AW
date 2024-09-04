<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role;

class usersModalEdit extends Component
{
    // Ya no se usara pues se renderiza directamente en UserTable
    public $roles;

    public function mount() {
        $this->roles = Role::all();
    }

    public function render()
    {
        return view('livewire.users-modal-edit');
    }

    /* public function EditUser(){
        $this->dispatchBrowserEvent('EditUser');
    } */

}
