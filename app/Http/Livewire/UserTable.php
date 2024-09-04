<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Columns\ImageColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\ComponentColumn;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Validator;
/* use Illuminate\Support\Facades\Validator; */
/* use App\Http\Livewire\usersModalEdit; */
use Illuminate\Support\Facades\Password as Reset;
use Spatie\Activitylog\Traits\LogsActivity;
use Carbon\Carbon;
use DB;

class UserTable extends DataTableComponent
{
    protected $model = User::class;

    // To show/hide the modal
    public bool $editUserModal = false;

    // The information currently being displayed in the modal
    public $userModalData;

    public $idrol, $user;

    /* protected $rules = [
        'idrol' => 'required',
        'userModalData.name' => 'required',
        'userModalData.last_name' => 'required',
        'userModalData.email' => 'required|string|email|max:255|unique:users,email,' . $this->user->id,
    ]; */

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
        $userUnique = ($this->user) ? $this->user->id : 0;
        return [
            'idrol' => 'required',
            'userModalData.phone' => 'required|max:255',
            'userModalData.name' => 'required|string|max:255',
            'userModalData.last_name' => 'required|string|max:255',
            'userModalData.email' => 'required|string|email|max:255|unique:users,email,' . $userUnique,
        ];
    }

    /* public function mount() {
        $this->roles = Role::all();
    } */
    /* public $modalUser = false; */

    public function configure(): void
    {
        $this->setPrimaryKey('id')->setSingleSortingDisabled();
        $this->roles = Role::all();
        /* ->setTrAttributes(function($row, $index) {
            return [
                'class' => 'user-row',
                'wire:click.prevent' => 'viewHistoryModal('.$row->id.')'
            ];
        }) *//* ->setTableRowUrl(function($row) {
            return "#";
        }); */
        /* ->setTableRowUrl(function($row) {
            //dd($row);
            //$this->dispatchBrowserEvent('EditUser', $row->id);
            // usersModalEdit::EditUser();
            // $edit = new usersModalEdit;
            // $edit->EditUser();
            //return ['wire:click.prevent' => 'customView('.$row->id.')'];
        }); */
    }

    /* public function getTableRowUrl(): string
    {
        return '#';
    } */

    /* public function setTableRowAttributes($row): array
    {
        return ['wire:click.prevent' => 'viewHistoryModal('.$row->id.')'];
    } */

    public function updateUser() {
        /* Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation'); */

        /* $this->user->name = $this->userModalData['name'];
        $this->user->last_name = $this->userModalData['last_name'];
        $this->user->phone = $this->userModalData['phone']; */

        $this->validate();

        if ($this->userModalData['email'] !== $this->user->email &&
            $this->user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($this->user, $this->userModalData);
        } else {
            $this->user->forceFill([
                'name' => $this->userModalData['name'],
                'last_name' => $this->userModalData['last_name'],
                'phone' => $this->userModalData['phone'],
                'email' => $this->userModalData['email'],
            ])->save();

            if($this->idrol != 0) {

                $this->user->syncRoles($this->idrol);

            } else {

                $this->user->roles()->detach();
    
            }
        }
    }

    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $this->userModalData['name'],
            'last_name' => $this->userModalData['last_name'],
            'phone' => $this->userModalData['phone'],
            'email' => $this->userModalData['email'],
            'email_verified_at' => null,
        ])->save();

        if($this->idrol != 0) {

            $this->user->syncRoles($this->idrol);

        } else {

            $this->user->roles()->detach();

        }

        $user->sendEmailVerificationNotification();
    }

    public function viewHistoryModal($modelId): void
    {
        $this->editUserModal = true;
        $this->user = User::findOrFail($modelId);
        $this->userModalData = $this->user->toArray();

        $this->idrol = ($this->user->roles->pluck('id')->count() > 0) ? $this->user->roles->pluck('id')[0] : 0;

        //dd($this->useridrol);
        //$user->syncRoles($role);
        //dd($this->userModalData);
    }

    public function resetModal(): void
    {
        $this->reset('editUserModal', 'userModalData');
    }

    public function customView(): string
    {
        return 'livewire.users-modal-edit';
    }

    /* public function EditUser($id){
        $this->dispatchBrowserEvent('EditUser',[
            'id'=>$id
        ]);
    } */

    public function bulkActions(): array
    {
        return [
            'activate'   => __('Activar'),
            'deactivate' => __('Desactivar'),
            'sendPassword'   => __('Enviar contraseña'),
            'deleteTokens' => __('Cerrar sesiones'),
        ];
    }

    public function filters(): array
    {
        return [
            DateFilter::make('Última modificación')
                ->filter(function(Builder $builder, string $value) {
                    $builder->where('updated_at', '>=', $value);
                }),
            SelectFilter::make('Activo')
                ->setFilterPillTitle('Estado del usuario')
                ->setFilterPillValues([
                    '1' => 'Activo',
                    '0' => 'Inactivo',
                ])
                ->options([
                    '' => 'Todos',
                    '1' => 'Activo',
                    '0' => 'Inactivo',
                ])
                ->filter(function(Builder $builder, string $value) {
                    if ($value === '1') {
                        $builder->where('status', 1);
                    } elseif ($value === '0') {
                        $builder->where('status', 0);
                    }
                }),
        ];
    }

    public function activate() {

        foreach($this->getSelected() as $id) {

            $user = User::find($id);

            $user->status = 1;

            DB::table('sessions')->where('user_id',$id)->delete();

            activity()
                ->withProperties(['useraffected' => $id])
                ->log('Usuario activado');

            $user->save();   

        }

        session()->flash('status', 'Usuarios activados con exito!');
 
        return redirect()->to('/users');
    }

    public function deactivate() {

        foreach($this->getSelected() as $id) {

            $user = User::find($id);

            $user->status = 0;

            DB::table('sessions')->where('user_id',$id)->delete();

            activity()
                ->withProperties(['useraffected' => $id])
                ->log('Usuario desactivado');

            $user->save();   

        }

        session()->flash('status', 'Usuarios desactivados con exito!');
 
        return redirect()->to('/users');
    }

    public function sendPassword() {
        $status = null;
        
        foreach($this->getSelected() as $id) {
            $user = User::find($id);

            $status = Reset::sendResetLink(
                $user->only('email')
            );
        }

        session()->flash('status', 'Restauración de contraseña enviada.');
 
        return redirect()->to('/users');
    }

    public function deleteTokens() {
        foreach($this->getSelected() as $id) {
            DB::table('sessions')->where('user_id',$id)->delete();
        }

        session()->flash('status', 'Todas las sesiónes han sido cerradas');
 
        return redirect()->to('/users');
    }


    public function columns(): array
    {
        return [
            Column::make('profile_photo_path')->hideIf(true),
            ImageColumn::make('Avatar')
            ->location(function($row) {
                if($row->profile_photo_path) {
                    return asset('storage/'.$row->profile_photo_path);
                } else {
                    return asset($row->profile_photo_url);
                }
            })
            ->attributes(function($row) {
                return [
                    'class' => 'avatar-img rounded-circle cursor-pointer mw-100px',
                    'wire:click.prevent' => 'viewHistoryModal('.$row->id.')',
                ];
            }),
        
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Nombre", "name")
                ->sortable()
                ->searchable(),
            Column::make("Apellidos", "last_name")
                ->sortable()
                ->searchable(),
            Column::make("Teléfono", "phone")
                ->sortable(),
            Column::make("Email", "email")
                ->sortable()
                ->searchable(),
     
                Column::make("Empresa", "company")
                ->sortable()
                ->searchable(),
                Column::make("Posición o Puesto", "position")
                ->sortable()
                ->searchable(),
                BooleanColumn::make('Activo','status')
                ->sortable(),
            Column::make("Creado", "created_at")
                ->sortable()
                ->format(function($value) {
                    return Carbon::parse($value)->diffForHumans();
                }),
            Column::make("Última modificación", "updated_at")
                ->sortable()
                ->format(function($value) {
                    return Carbon::parse($value)->diffForHumans();
                }),
        ];
    }
}
