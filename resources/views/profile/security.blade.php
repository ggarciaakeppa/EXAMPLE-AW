@push('css')
<link rel="stylesheet" href="{{ asset('/assets/custom/modal/modal.css') }}">
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
									<a href="{{ route('profile.show') }}" class="nav-link">
									General
									</a>
								</li>
								<li class="nav-item">
									<a href="{{ route('profile.security') }}" class="nav-link active">
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
		@if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
		<div class="row justify-content-between align-items-center mb-5">
			<div class="col-12 col-md-9 col-xl-7">
				<!-- Heading -->
				<h2 class="mb-2">
					Cambia tu contraseña
				</h2>
				<!-- Text -->
				<p class="text-muted mb-xl-0">
                    Antes de poder cambiar la contraseña, le solicitaremos unos requisitos para poder hacerlo.
				</p>
			</div>
			<!-- <div class="col-12 col-xl-auto">
				<button class="btn btn-white">
				Forgot your password?
				</button>
			</div> -->
		</div>
		<!-- / .row -->
		<div class="row">
			<div class="col-12 col-md-6 order-md-2">
				<!-- Card -->
				<div class="card bg-light border ms-md-4">
					<div class="card-body">
						<!-- Text -->
						<p class="mb-2">
                            Requisitos de contraseña
						</p>
						<!-- Text -->
						<p class="small text-muted mb-2">
                            Para crear una nueva contraseña, debe cumplir con todos los siguientes requisitos:
						</p>
						<!-- List group -->
						<ul class="small text-muted ps-4 mb-0">
							<li>
                                Mínimo 8 caracteres
							</li>
							<li>
                                Al menos un carácter especial
							</li>
							<li>
                                Al menos un numero
							</li>
							<li>
                                No puede ser igual a una contraseña anterior
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-6">
				@livewire('profile.update-password-form')
			</div>
		</div>
	    <hr class="my-5">
	</div>
	<!-- / .row -->
	<!-- <x-jet-section-border /> -->
	@endif
	<div class="col-12 col-lg-10 col-xl-8">
		@livewire('profile.logout-other-browser-sessions-form')
	</div>
	@if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
	<div class="col-12 col-lg-10 col-xl-8">
        <hr class="my-5">
		@livewire('profile.delete-user-form')
		<hr class="my-5">
	</div>
	@endif
	</div>
</x-app-layout>