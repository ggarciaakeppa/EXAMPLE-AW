<x-jet-action-section>
	<!-- <x-slot name="title">
		{{ __('Sesiones del navegador') }}
		</x-slot>
		
		<x-slot name="description">
		{{ __('Administre y cierre la sesión de sus sesiones activas en otros navegadores y dispositivos.') }}
		</x-slot> -->
	<x-slot name="content">
		<div class="row justify-content-between align-items-center mb-5">
			<div class="col-12 col-md-9 col-xl-7">
				<!-- Heading -->
				<h2 class="mb-2">
					Historial de dispositivos
				</h2>
				<!-- Text -->
				<p class="text-muted mb-xl-0">
					{{ __('Si es necesario, puede cerrar la sesión de todas las demás sesiones de su navegador en todos sus dispositivos. Algunas de sus sesiones recientes se enumeran a continuación; sin embargo, esta lista puede no ser exhaustiva. Si cree que su cuenta se ha visto comprometida, también debe actualizar su contraseña.') }}
				</p>
			</div>
			<div class="col-12 col-xl-auto">
				<!-- Button -->
				<x-jet-button wire:click="confirmLogout" wire:loading.attr="disabled" class="btn btn-danger">
					{{ __('Cerrar sesión en otras sesiones del navegador') }}
				</x-jet-button>
				<x-jet-action-message on="loggedOut">
					{{ __('Hecho.') }}
				</x-jet-action-message>
			</div>
		</div>
		<!-- / .row -->
		<!-- Card -->
		@if (count($this->sessions) > 0)
		<div class="card">
			<div class="card-body">
				<!-- List group -->
				<div class="list-group list-group-flush my-n3">
					@foreach ($this->sessions as $session)
					<div class="list-group-item">
						<div class="row align-items-center">
							<div class="col-auto">
								<!-- Icon -->
								@if ($session->agent->isDesktop())
								<i class="fe fe-monitor h1"></i>
								@else
								<i class="fe fe-smartphone h1"></i>
								@endif
							</div>
							<div class="col ms-n2">
								<!-- Heading -->
								<h4 class="mb-1">
									{{ $session->agent->platform() ? $session->agent->platform() : __('Unknown') }} <span class="fw-normal">{{ $session->agent->browser() ? $session->agent->browser() : __('Unknown') }}</span>
								</h4>
								<!-- Text -->
								<small class="text-muted">
								{{ $session->ip_address }}, 
								<time datetime="2020-04-20T16:16">
								@if ($session->is_current_device)
								{{ __('Este dispositivo') }}
								@else
								{{ __('Último dispositivo') }} {{ $session->last_active }}
								@endif
								</time>
								</small>
							</div>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div>
		<!-- END CARD -->
		@endif
		<!-- Log Out Other Devices Confirmation Modal -->
		<x-jet-dialog-modal wire:model="confirmingLogout">
			<x-slot name="title">
				{{ __('Cerrar sesión de otras sesiones del navegador') }}
			</x-slot>
			<x-slot name="content">
				{{ __('Ingrese su contraseña para confirmar que desea cerrar sesión en sus otras sesiones de navegador en todos sus dispositivos.') }}
				<div class="mt-4" x-data="{}" x-on:confirming-logout-other-browser-sessions.window="setTimeout(() => $refs.password.focus(), 250)">
					<x-jet-input type="password" class="form-control"
						placeholder="{{ __('Password') }}"
						x-ref="password"
						wire:model.defer="password"
						wire:keydown.enter="logoutOtherBrowserSessions" />
					<x-jet-input-error for="password" class="mt-2" />
				</div>
			</x-slot>
			<x-slot name="footer">
				<x-jet-secondary-button wire:click="$toggle('confirmingLogout')" wire:loading.attr="disabled" class="btn-white">
					{{ __('Cancelar') }}
				</x-jet-secondary-button>
				<x-jet-button class="btn-danger"
					wire:click="logoutOtherBrowserSessions"
					wire:loading.attr="disabled">
					{{ __('Cerrar sesión de otras sesiones del navegador') }}
				</x-jet-button>
			</x-slot>
		</x-jet-dialog-modal>
	</x-slot>
</x-jet-action-section>