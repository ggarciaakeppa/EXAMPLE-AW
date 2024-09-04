<x-app-layout>
    <x-slot name="header">
        <!-- Header -->
        <div class="header">
            <div class="header-body">
                <div class="row align-items-center">
                    <div class="col">

                        <!-- Pretitle -->
                        <h6 class="header-pretitle">
                            Administrar
                        </h6>

                        <!-- Title -->
                        <h1 class="header-title">
                            Usuarios
                        </h1>

                    </div>
                    <div class="col-auto">

                        {{-- <!-- Button -->
                        <button class="btn btn-primary lift" data-bs-toggle="modal" data-bs-target="#modalUser" id="adduser">
                            Nuevo usuario
                        </button> --}}
                        @if(auth()->user()->can('roles'))
                        <!-- Button -->
                        <button class="btn btn-primary lift" data-bs-toggle="modal" data-bs-target="#modalRolPermisions">
                            Administrar permisos
                        </button>
                        @endif
                    </div>
                </div>
       
            </div>
        </div>
    </x-slot>

    <!-- / .row -->
    <livewire:success-message class="mb-4" />

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <livewire:user-table />
            </div>
        </div>
    </div>

    <!-- / .row -->
    <div class="modal fade" id="modalRolPermisions" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <livewire:roles-permisos />
        </div>
    </div>

    <!-- Modal: Users -->
    <div class="modal fade" id="modalUser" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <livewire:users-modal />
        </div>
    </div>

</x-app-layout>
