<x-jet-dialog-modal wire:model="editUserModal">
	<x-slot name="title">
		@lang('Editar usuario')
	</x-slot>
	<x-slot name="content">
		<div class="row">
			<div class="col-md-6">
					<label for="rol_update">Rol</label>
					<select id="rol_update" class="form-control" name="rol" wire:model.defer="idrol">
						<option value="0">Sin ningun rol</option>
						@foreach($roles as $rol)
							<option value="{{ $rol->id }}">{{ $rol->name }}</option>
						@endforeach
					</select>
					<x-jet-input-error for="rol_update" class="mt-2" />
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="email_update" class="form-label">{{ __('Email') }}</label>
					<input type="email" id="email_update" class="form-control" wire:model.defer="userModalData.email" readonly>
					<x-jet-input-error for="userModalData.email" class="mt-2" />
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="name" class="form-label">{{ __('Name') }}</label>
					<input type="text" id="name_update" class="form-control" wire:model.defer="userModalData.name" autocomplete="name">
					<x-jet-input-error for="userModalData.name" class="mt-2" />
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="last_name_update" class="form-label">{{ __('Apellidos') }}</label>
					<input type="text" id="last_name_update" class="form-control" wire:model.defer="userModalData.last_name" autocomplete="last_name">
					<x-jet-input-error for="userModalData.last_name" class="mt-2" />
				</div>
			</div>
			
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="phone_update" class="form-label">{{ __('Teléfono') }}</label>
					<input type="text" id="phone_update" class="form-control" placeholder="+52 ___-___-____" data-inputmask="'mask': '(+52) 999-999-9999'" wire:model.defer="userModalData.phone" autocomplete="phone">
					<x-jet-input-error for="userModalData.phone" class="mt-2" />
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="name" class="form-label">{{ __('Estatus') }}</label>
					<input type="text" readonly class="form-control" 
						value="{{ isset($userModalData['status']) ? ($userModalData['status'] == 1 ? 'Activo' : 'Inactivo') : 'N/A' }}">
					<x-jet-input-error for="userModalData.status" class="mt-2" />
				</div>
			</div>			
		</div>
	</x-slot>
	email
	<x-slot name="footer">
		<x-jet-secondary-button wire:click="resetModal" wire:loading.attr="disabled" class="btn-white">
			{{ __('Cancelar') }}
		</x-jet-secondary-button>
		<x-jet-button
			class="btn-primary"
			wire:click="updateUser"
			wire:loading.attr="disabled">
			{{ __('Guardar') }}
		</x-jet-button>
        <div wire:loading wire:target="updateUser">
            Procesando...
        </div>
	</x-slot>
</x-jet-dialog-modal>