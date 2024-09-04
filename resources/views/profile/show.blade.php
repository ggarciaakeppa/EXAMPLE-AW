@push('css')
@endpush
<x-app-layout>
    <x-slot name="header">
        <div class="col-12 col-lg-10 col-xl-8">
            <div class="header mt-md-5">
                <div class="header-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <!-- Pretitle -->
                            <h6 class="header-pretitle">
                            Información general
                            </h6>
                            <!-- Title -->
                            <h1 class="header-title">
                            Perfil
                            </h1>
                        </div>
                    </div>
                    <!-- / .row -->
                    <div class="row align-items-center">
                        <div class="col">
                            <!-- Nav -->
                            <ul class="nav nav-tabs nav-overflow header-tabs">
                            <li class="nav-item">
                                <a href="{{ route('profile.show') }}" class="nav-link active">
                                General
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('profile.security') }}" class="nav-link">
                                Seguridad
                                </a>
                            </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="col-12 col-lg-10 col-xl-8">
        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
            @livewire('profile.update-profile-information-form')
        @endif
    </div>

</x-app-layout>
