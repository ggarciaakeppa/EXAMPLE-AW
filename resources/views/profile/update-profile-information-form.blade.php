<x-jet-form-section submit="updateProfileInformation">

    <!-- <x-slot name="title">
        {{ __('Información del perfil') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Actualice la información de perfil y la dirección de correo electrónico de su cuenta.') }}
    </x-slot> -->

    <x-slot name="form">

        <div class="row justify-content-between align-items-center" x-data="{photoName: null, photoPreview: null}">
            <div class="col">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <!-- Profile Photo File Input display:none -->
                        <input type="file" class="d-none"
                            wire:model="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />
                        <!-- Avatar -->
                        <!-- Current Profile Photo -->
                        <div class="avatar" x-show="! photoPreview">
                            <img class="avatar-img rounded-circle" src="{{ $this->user->profile_photo_url }}" alt="{{ $this->user->name }}">
                        </div>
                        <!-- New Profile Photo Preview -->
                        <div class="avatar" x-show="photoPreview">
                            <img class="avatar-img rounded-circle" x-bind:style="'background-image: url(\'' + photoPreview + '\');background-position: center;background-size: contain;'">
                        </div>
                    </div>
                    <div class="col ms-n2">
                        <!-- Heading -->
                        <h4 class="mb-1">
                            Tu avatar
                        </h4>
                        <!-- Text -->
                        <small class="text-muted">              
                            PNG o JPG no mayor a 1000px de ancho y alto.
                        </small>
                    </div>
                </div>
                <!-- / .row -->
            </div>
            <div class="col-auto">
                <!-- Button -->
                <button class="btn btn-sm btn-primary" type="button" x-on:click.prevent="$refs.photo.click()">
                    Seleccione una nueva foto
                </button>
                @if ($this->user->profile_photo_path)
                    <button type="button" class="btn btn-sm btn-danger" wire:click="deleteProfilePhoto">
                        {{ __('Quitar foto') }}
                    </button>
                @endif
            </div>
        </div>
        <!-- / .row -->
        <!-- Divider -->
        <hr class="my-5">
        <div class="row">
            <div class="col-12 col-md-6">
                <!-- First name -->
                <div class="form-group">
                    <!-- Label -->
                    <label class="form-label">
                    Nombre
                    </label>
                    <!-- Input -->
                    <input type="text" id="name" class="form-control" wire:model.defer="state.name" autocomplete="name">
                    <x-jet-input-error for="name" class="mt-2" />
                </div>
            </div>
            <div class="col-12 col-md-6">
                <!-- Last name -->
                <div class="form-group">
                    <!-- Label -->
                    <label class="form-label">
                    Apellidos
                    </label>
                    <!-- Input -->
                    <input type="text" id="last_name" class="form-control" wire:model.defer="state.last_name" autocomplete="last_name">
                    <x-jet-input-error for="last_name" class="mt-2" />
                </div>
            </div>
            <div class="col-md-6">
                <!-- Email address -->
                <div class="form-group">
                    <!-- Label -->
                    <label class="mb-1">
                    Correo electrónico
                    </label>
                    <!-- Form text -->
                    <small class="form-text text-muted">
                    Este contacto solo sera para su uso personal
                    </small>
                    <!-- Input -->
                    <input type="email" id="email" class="form-control" wire:model.defer="state.email">
                    <x-jet-input-error for="email" class="mt-2" />
                </div>
            </div>
            <div class="col-md-6">
                <!-- Phone -->
                <div class="form-group">
                    <!-- Label -->
                    <label class="form-label">
                    Teléfono
                    </label>
                    <!-- Input -->
                    <input type="text" id="phone" class="form-control mb-3" placeholder="+52 ___-___-____" data-inputmask="'mask': '(+52) 999-999-9999'" wire:model.defer="state.phone" autocomplete="phone">
                    <x-jet-input-error for="phone" class="mt-2" />
                </div>
            </div>
        </div>

        <x-slot name="actions">
            <x-jet-button class="btn btn-primary" wire:loading.attr="disabled" wire:target="photo">
                {{ __('Guardar') }}
            </x-jet-button>
            
            <x-jet-action-message on="saved">
                {{ __('Guardando...') }}
            </x-jet-action-message>
            @if(!auth()->user()->can('Admin'))
            <input type ='button' class="btn btn-primary"  value = 'Salir' onclick="location.href = '/'"/>
            @endif
        </x-slot>
        
    </x-slot>
    <hr>
</x-jet-form-section>