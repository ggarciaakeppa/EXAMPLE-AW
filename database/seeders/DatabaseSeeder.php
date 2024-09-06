<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class DatabaseSeeder extends Seeder
{
  
    public function run()
    {
        $adminUsers =  Permission::create(['name' => 'usuarios']);

        $adminRoles =  Permission::create(['name' => 'roles']);

           //Creación de roles
           $masterRole = Role::create(['name' => 'Maestro']);
           //Agrega los necesarios aqui....
            //Asiganación de permisos
            $masterRole->givePermissionTo($adminUsers);
         $masterRole->givePermissionTo($adminRoles);

            //Creación de usuarios
        $userMaster = User::create([
            'id' => 1,
            'name' => 'Administrador',
            'last_name' => 'Master',
            'email' => 'ggarcia@akeppa.mx',
            'status' => 1,
            'password' => Hash::make('123456789'),
            'phone' => '(+52) 333-333-3200',
        ]);

        $userMaster->assignRole($masterRole);
    }
}
