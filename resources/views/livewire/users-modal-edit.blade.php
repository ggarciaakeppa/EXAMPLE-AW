<x-jet-dialog-modal wire:model="editUserModal">
	<x-slot name="title">
		@lang('Asignar rol')
	</x-slot>
	<x-slot name="content">
		<div class="form-group">
			<label for="rol_update">Rol</label>
			<select id="rol_update" class="form-control" name="rol" wire:model.defer="idrol">
                <option value="0">Sin ningun rol</option>
                @foreach($roles as $rol)
                    <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                @endforeach
			</select>
            <x-jet-input-error for="rol_update" class="mt-2" />
		</div>
	</x-slot>
	
	<x-slot name="footer">
		<x-jet-secondary-button wire:click="resetModal" wire:loading.attr="disabled" class="btn-white lift">
			{{ __('Cancelar') }}
		</x-jet-secondary-button>
		<x-jet-button
			class="btn-primary lift"
			wire:click="updateUser"
			wire:loading.attr="disabled">
			{{ __('Guardar') }}
		</x-jet-button>
        <div wire:loading wire:target="updateUser">
            Procesando...
        </div>
	</x-slot>
</x-jet-dialog-modal>