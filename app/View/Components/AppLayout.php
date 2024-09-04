<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

/* use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission; */

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        /* $role = Role::find(1);
        $role->syncPermissions([1,2,3]); */

        return view('layouts.app');
    }
}
