<x-jet-form-section submit="updatePassword">
	<!-- <x-slot name="title">
		{{ __('Actualiza contraseña') }}
		</x-slot>
		
		<x-slot name="description">
		{{ __('Asegúrese de que su cuenta esté usando una contraseña larga y aleatoria para mantenerse seguro.') }}
		</x-slot> -->
	<!-- Form -->
	<x-slot name="form">
		<!-- Password -->
		<div class="form-group">
			<!-- Label -->
			<x-jet-label class="form-label" for="current_password" value="{{ __('Contraseña actual') }}" />
			<!-- Input -->
			<x-jet-input id="current_password" type="password" class="form-control" wire:model.defer="state.current_password" autocomplete="current-password" />
			<x-jet-input-error for="current_password" class="mt-2" />
		</div>
		<!-- New password -->
		<div class="form-group">
			<!-- Label -->
			<x-jet-label class="form-label" for="password" value="{{ __('Nueva contraseña') }}" />
			<!-- Input -->
			<x-jet-input id="password" type="password" class="form-control" wire:model.defer="state.password" autocomplete="new-password" />
			<x-jet-input-error for="password" class="mt-2" />
		</div>
		<!-- Confirm new password -->
		<div class="form-group">
			<!-- Label -->
			<x-jet-label class="form-label" for="password_confirmation" value="{{ __('Confirmar contraseña') }}" />
			<!-- Input -->
			<x-jet-input id="password_confirmation" type="password" class="form-control" wire:model.defer="state.password_confirmation" autocomplete="new-password" />
			<x-jet-input-error for="password_confirmation" class="mt-2" />
		</div>
		<!-- Submit -->
		<x-slot name="actions">
			<x-jet-button class="btn  btn-primary lift">
				<span wire:loading.remove>
                    {{ __('Guardar') }}
                </span>
                <span wire:loading>Cargando...</span>
			</x-jet-button>
		</x-slot>
		@if (session('status'))
		<div class="alert alert-success alert-dismissible fade show" role="alert">
			{{ session('status') }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
	@endif
	</x-slot>
</x-jet-form-section>