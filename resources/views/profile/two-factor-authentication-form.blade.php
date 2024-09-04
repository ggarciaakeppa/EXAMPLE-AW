<x-jet-action-section>
	<!-- <x-slot name="title">
		{{ __('Autenticación de dos factores') }}
		</x-slot>
		
		<x-slot name="description">
		{{ __('Agregue seguridad adicional a su cuenta mediante la autenticación de dos factores.') }}
		</x-slot> -->
	<x-slot name="content">
		<div class="row justify-content-between align-items-center mb-5">
			<div class="col-12 col-md-9 col-xl-7">
				<!-- Heading -->
				<h2 class="mb-2">
					{{ __('Autenticación de dos factores') }}
				</h2>
				<!-- Text -->
				<p class="text-muted mb-md-0">
					{{ __('Agregue seguridad adicional a su cuenta mediante la autenticación de dos factores.') }}
				</p>
				<p>
					@if ($this->enabled)
					{{ __('Ha habilitado la autenticación de dos factores.') }}
					@else
					{{ __('No ha habilitado la autenticación de dos factores.') }}
					@endif
				</p>
			</div>
			<div class="col-12 col-md-auto">
				<!-- Button -->
				@if (! $this->enabled)
				<x-jet-confirms-password wire:then="enableTwoFactorAuthentication">
					<x-jet-button type="button" wire:loading.attr="disabled" class="btn btn-primary">
						{{ __('Habilitar') }}
					</x-jet-button>
				</x-jet-confirms-password>
				@else
				<x-jet-confirms-password wire:then="disableTwoFactorAuthentication">
					<x-jet-danger-button wire:loading.attr="disabled" class="btn btn-danger">
						{{ __('Deshabilitar') }}
					</x-jet-danger-button>
				</x-jet-confirms-password>
				@endif
			</div>
		</div>
		<!-- / .row -->
		<!-- Card -->
		@if ($this->enabled)
		<div class="card">
			<div class="card-body">
				<!-- List group -->
				<div class="list-group list-group-flush my-n3">
					<div class="list-group-item">
						<div class="row align-items-center">
							@if ($showingQrCode)
							<!-- Heading -->
							<h4 class="mb-1">
								{{ __('La autenticación de dos factores ahora está habilitada.') }} <i class="fe fe-info text-muted ms-1" data-bs-toggle="tooltip" data-title="La autenticación de dos factores ahora está habilitada"></i>
							</h4>
							<!-- Text -->
							<small class="text-muted">
							{{ __('Escanee el siguiente código QR usando la aplicación de autenticación de su teléfono.') }}
							</small>
                            <hr class="navbar-divider my-3">
							<div class="col-auto">
								{!! $this->user->twoFactorQrCodeSvg() !!}
							</div>
							<div class="mt-4 max-w-xl text-sm text-gray-600">
								<p class="font-semibold">
									{{ __('Clave de configuración') }}: {{ decrypt($this->user->two_factor_secret) }}
								</p>
							</div>

							@if ($showingConfirmation)
							
							<x-jet-label for="code" class="form-label" value="{{ __('Codigo') }}" />
								<div class="col-12 col-md-4">

									<x-jet-input id="code" type="text" name="code" class="form-control" inputmode="numeric" autofocus autocomplete="one-time-code"
										wire:model.defer="code"
										wire:keydown.enter="confirmTwoFactorAuthentication" />

									<x-jet-input-error for="code" class="mt-2" />
								</div>
								<div class="col-12 col-md-2">
									<x-jet-confirms-password wire:then="confirmTwoFactorAuthentication">
										<x-jet-button type="button" wire:loading.attr="disabled" class="btn btn-primary">
											{{ __('Habilitar') }}
										</x-jet-button>
									</x-jet-confirms-password>
								</div>
							@endif
							@endif
						</div>
						<!-- / .row -->
					</div>
					@if ($showingRecoveryCodes)
					<div class="mt-4 max-w-xl text-sm text-gray-600">
						<p class="font-semibold">
							{{ __('Guarde estos códigos de recuperación en un administrador de contraseñas seguro. Se pueden utilizar para recuperar el acceso a su cuenta si pierde su dispositivo de autenticación de dos factores.') }}
						</p>
					</div>
					<div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 rounded-lg">
						@foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
						<div>{{ $code }}</div>
						@endforeach
					</div>
					@endif
					<div class="list-group-item">
						<div class="row align-items-center">
							<div class="col">
								<!-- Heading -->
								<h4 class="mb-1">
                                    Códigos de recuperación <i class="fe fe-info text-muted ms-1" data-bs-toggle="tooltip" data-title="Usamos el número de teléfono que proporciona en general"></i>
								</h4>
								<!-- Text -->
								<small class="text-muted">
								    {{ __('Guarde estos códigos de recuperación en un administrador de contraseñas seguro. Se pueden utilizar para recuperar el acceso a su cuenta si pierde su dispositivo de autenticación de dos factores.') }}
								</small>
							</div>
							<div class="col-auto">
								@if ($showingRecoveryCodes)
								<x-jet-confirms-password wire:then="regenerateRecoveryCodes">
									<x-jet-secondary-button class="btn-sm btn-white">
										{{ __('Regenerar códigos de recuperación') }}
									</x-jet-secondary-button>
								</x-jet-confirms-password>
								@else
								<x-jet-confirms-password wire:then="showRecoveryCodes">
									<x-jet-secondary-button class="btn-sm btn-white">
										{{ __('Mostrar códigos de recuperación') }}
									</x-jet-secondary-button>
								</x-jet-confirms-password>
								@endif
							</div>
						</div>
						<!-- / .row -->
					</div>
				</div>
			</div>
		</div>
		@endif
	</x-slot>
	<!-- termina -->
</x-jet-action-section>