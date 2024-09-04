<div>
    <div class="header">
		<div class="header-body">
			<div class="row align-items-center">
				<div class="col">
					<!-- Pretitle -->
					<h6 class="header-pretitle">
						Administrar
					</h6>
					<!-- Title -->
					<h1 class="header-title">
						Ingresos Autos
					</h1>
				</div>
				<div class="col-auto">
					<a class="btn btn-primary lift" href="{{ route('ingreso-auto.create') }}">
					    Nuevo ingreso
                    </a>
				</div>
			</div>
		</div>
	</div>
	<!-- / .row -->
	<livewire:success-message class="mb-4" />

    <div class="col-12">
		<div class="card">
			<div class="card-body">
                <livewire:ingreso.ingreso-auto-table />
                <!-- <table>
                    <thead>
                        <tr>
                            <th>Placas</th>
                            <th>Nombre</th>
                            <th>Motivo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ingresos as $ingreso)
                            <tr>
                                <td>{{ $ingreso->placas }}</td>
                                <td>{{ $ingreso->nombre }}</td>
                                <td>{{ $ingreso->motivo }}</td>
                                <td>
                                    <a href="{{ route('ingreso-autos.edit', $ingreso->id) }}">Editar</a>
                                    <button wire:click="deleteIngreso({{ $ingreso->id }})">Eliminar</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table> -->
			</div>
		</div>
	</div>

</div>

