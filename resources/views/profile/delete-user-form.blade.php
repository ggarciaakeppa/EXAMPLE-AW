<x-jet-action-section>
	<!-- <x-slot name="title">
		{{ __('Borrar cuenta') }}
		</x-slot>
		
		<x-slot name="description">
		{{ __('Elimina permanentemente tu cuenta.') }}
		</x-slot> -->
	<x-slot name="content">
		<div class="row justify-content-between">
			<div class="col-12 col-md-6">
				<!-- Heading -->
				<h4>
					Borrar cuenta
				</h4>
				<!-- Text -->
				<p class="small text-muted mb-md-0">
					{{ __('Una vez que se elimine su cuenta, todos sus recursos y datos se eliminarán permanentemente.') }}
				</p>
			</div>
			<div class="col-auto">
				<!-- Button -->
				<x-jet-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled" class="btn btn-danger">
					{{ __('Borrar cuenta') }}
				</x-jet-danger-button>
			</div>
		</div>
		<!-- Delete User Confirmation Modal -->
		<x-jet-dialog-modal wire:model="confirmingUserDeletion">
			<x-slot name="title">
				{{ __('Borrar cuenta') }}
			</x-slot>
			<x-slot name="content">
				{{ __('¿Estás seguro de que deseas eliminar tu cuenta? Una vez que se elimine su cuenta, todos sus recursos y datos se eliminarán permanentemente. Ingrese su contraseña para confirmar que desea eliminar permanentemente su cuenta.') }}
				<div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
					<x-jet-input type="password" class="form-control"
						placeholder="{{ __('Password') }}"
						x-ref="password"
						wire:model.defer="password"
						wire:keydown.enter="deleteUser" />
					<x-jet-input-error for="password" class="mt-2" />
				</div>
			</x-slot>
			<x-slot name="footer">
				<x-jet-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled" class="btn-white">
					{{ __('Cancelar') }}
				</x-jet-secondary-button>
				<x-jet-danger-button class="ml-2" wire:click="deleteUser" wire:loading.attr="disabled" class="btn btn-danger">
					{{ __('Borrar cuenta') }}
				</x-jet-danger-button>
			</x-slot>
		</x-jet-dialog-modal>
	</x-slot>
</x-jet-action-section>