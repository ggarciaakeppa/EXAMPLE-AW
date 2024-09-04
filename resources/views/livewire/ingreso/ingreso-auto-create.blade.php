<x-app-layout>
    <div class="header">
		<div class="header-body">
			<div class="row align-items-center">
				<div class="col">
					<!-- Pretitle -->
					<h6 class="header-pretitle">
						Ingresos Autos
					</h6>
					<!-- Title -->
					<h1 class="header-title">
						Nuevo Ingreso
					</h1>
				</div>
				<div class="col-auto" wire:click="ingresoAutoStore">
					<button class="btn btn-primary lift">
					    Dejar pasar
                    </button>
				</div>
			</div>
		</div>
	</div>
	<!-- / .row -->
	<livewire:success-message class="mb-4" />

    <div class="col-12">
		<div class="card">
			<div class="card-body">
				<!-- formulario-component.blade.php -->
					<!-- <form wire:submit.prevent="ingresoAutoStore"> -->
						<div class="mb-4">
							<label for="placas" class="block text-gray-700 font-semibold">Placas de carro</label>
							<input wire:model="placas" type="text" id="placas" class="form-input mt-1 block w-full">
						</div>

						<div class="mb-4">
							<label for="nombre_conductor" class="block text-gray-700 font-semibold">Nombre del conductor</label>
							<input wire:model="nombreConductor" type="text" id="nombre_conductor" class="form-input mt-1 block w-full">
						</div>

						<div class="mb-4">
							<label for="motivo" class="block text-gray-700 font-semibold">Motivo</label>
							<select wire:model="motivo" id="motivo" class="form-select mt-1 block w-full">
								<option value="">Selecciona un motivo</option>
								@foreach ($motivos as $motivo)
									<option value="{{ $motivo }}">{{ $motivo }}</option>
								@endforeach
							</select>
						</div>

						<div class="mb-4">
							<label for="direccion_visita" class="block text-gray-700 font-semibold">Dirección de visita</label>
							<select wire:model="direccionVisita" id="direccion_visita" class="form-select mt-1 block w-full">
								<option value="">Selecciona una dirección</option>
								@foreach ($direccionesVisita as $direccion)
									<option value="{{ $direccion }}">{{ $direccion }}</option>
								@endforeach
							</select>
						</div>

						<div class="mb-4">
							<label for="marca_modelo" class="block text-gray-700 font-semibold">Marca y modelo del auto</label>
							<input wire:model="marcaModelo" type="text" id="marca_modelo" class="form-input mt-1 block w-full">
						</div>

						<div class="mb-4">
							<label for="color_auto" class="block text-gray-700 font-semibold">Color del auto (RGBA)</label>
							<input wire:model="colorAuto" type="text" id="color_auto" class="form-input mt-1 block w-full">
						</div>

						<div class="mb-4">
							<label for="cono_credencial" class="block text-gray-700 font-semibold">Cono/Credencial</label>
							<input wire:model="conoCredencial" type="text" id="cono_credencial" class="form-input mt-1 block w-full">
						</div>

						<div class="mb-4">
							<label for="permiso" class="block text-gray-700 font-semibold">Permiso</label>
							<input wire:model="permiso" type="checkbox" id="permiso" class="form-checkbox mt-1">
						</div>

						<div class="mb-4">
							<label for="key_dinamico" class="block text-gray-700 font-semibold">Key dinámico</label>
							<input wire:model="keyDinamico" type="text" id="key_dinamico" class="form-input mt-1 block w-full">
						</div>

						<div class="mb-4">
							<label for="notas_auto" class="block text-gray-700 font-semibold">Notas del auto</label>
							<textarea wire:model="notasAuto" id="notas_auto" class="form-textarea mt-1 block w-full"></textarea>
						</div>

						<div class="mb-6">
							<label for="notas_domicilio" class="block text-gray-700 font-semibold">Notas del domicilio</label>
							<textarea wire:model="notasDomicilio" id="notas_domicilio" class="form-textarea mt-1 block w-full"></textarea>
						</div>

						<!-- <div>
							<button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Enviar</button>
						</div> -->
					<!-- </form> -->
			</div>
		</div>
	</div>

</x-app-layout>

