<div class="modal-content">
	<div class="modal-card card">
		<div class="card-header">
			<!-- Title -->
			<h4 class="card-header-title" id="ModalTitle">
				Crear usuario
			</h4>
			<!-- Close -->
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="card-body">
			<div class="form-group">
				<label for="rol_update">Rol</label>
				<select id="rol_update" class="form-control" name="rol" wire:model.defer="idrol">
					<option value="0">Sin ningun rol</option>
					@foreach($roles as $rol)
					<option value="{{ $rol->id }}">{{ $rol->name }}</option>
					@endforeach
				</select>
				<x-jet-input-error for="idrol" class="mt-2" />
			</div>
			<div class="form-group">
				<label for="name" class="form-label">{{ __('Name') }}</label>
				<input type="text" id="name_update" class="form-control" wire:model.defer="userModalData.name" autocomplete="name">
				<x-jet-input-error for="userModalData.name" class="mt-2" />
			</div>
			<div class="form-group">
				<label for="name" class="form-label">{{ __('Apellidos') }}</label>
				<input type="text" id="last_name_update" class="form-control" wire:model.defer="userModalData.last_name" autocomplete="last_name">
				<x-jet-input-error for="userModalData.last_name" class="mt-2" />
			</div>
			<div class="form-group">
				<label for="email" class="form-label">{{ __('Email') }}</label>
				<input type="email" id="email_update" class="form-control" wire:model.defer="userModalData.email">
				<x-jet-input-error for="userModalData.email" class="mt-2" />
			</div>
			<div class="form-group">
				<label for="telefono" class="form-label">{{ __('Teléfono') }}</label>
				<input type="text" id="phone_update" class="form-control" placeholder="+52 ___-___-____" data-inputmask="'mask': '(+52) 999-999-9999'" wire:model.defer="userModalData.phone" autocomplete="phone">
				<x-jet-input-error for="userModalData.phone" class="mt-2" />
			</div>
		</div>
		<div class="modal-footer bg-light">
			<button type="button" class="btn btn-white" data-bs-dismiss="modal">Cerrar</button>
			<x-jet-button
                class="btn-primary"
                wire:click="createUser"
                wire:loading.attr="disabled">
                {{ __('Guardar') }}
            </x-jet-button>
            <div wire:loading wire:target="createUser">
                Procesando...
            </div>
		</div>
	</div>
</div>