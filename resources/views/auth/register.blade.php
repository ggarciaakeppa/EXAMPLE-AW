<!-- CONTENT ================================================== -->
<x-guest-layout>
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-12 col-md-5 col-lg-6 col-xl-4 px-lg-6 my-5 align-self-center">

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Email address -->
                <div class="form-group">
                    <div class="row">
                        <div class="col-6 col-md-6 col-xs-12">
                            <!-- Label -->
                            <label class="form-label">
                                {{ __('Name') }}
                            </label>

                            <!-- Input -->
                            <input id="name" type="text" name="name" :value="old('name')" required autofocus placeholder="Ingresa tu nombre" class="form-control">
                        </div>
                        <div class="col-6 col-md-6 col-xs-12">
                            <!-- Label -->
                            <label class="form-label">
                                {{ __('Apellidos') }}
                            </label>

                            <!-- Input -->
                            <input id="last_name" type="text" name="last_name" :value="old('last_name')" required autofocus placeholder="Ingresa tus apellidos" class="form-control">
                        </div>
                    </div>

                </div>

                <!-- Email address -->
                <div class="form-group">
                    <div class="row">
                        <div class="col-6 col-md-6 col-xs-12">
                            <!-- Label -->
                            <label class="form-label">
                                Correo electrónico
                            </label>

                            <!-- Input -->
                            <input id="email" type="email" name="email" :value="old('email')" required autofocus placeholder="nombre@dominio.com" class="form-control">
                        </div>
                        <div class="col-6 col-md-6 col-xs-12">
                            <!-- Label -->
                            <label class="form-label">
                                Celular
                            </label>

                            <!-- Input -->
                            <input id="phone" type="text" name="phone" :value="old('phone')" required autofocus placeholder="+52 ___-___-____" data-inputmask="'mask': '(+52) 999-999-9999'" class="form-control">
                        </div>
                    </div>
                    

                </div>

                <div class="form-group">

                    <div class="row">
                        <div class="col">

                            <!-- Label -->
                            <label class="form-label">
                                Contraseña
                            </label>

                        </div>

                    </div> <!-- / .row -->

                    <!-- Input group -->
                    <div class="input-group input-group-merge">

                        <!-- Input -->
                        <input class="form-control" type="password" id="password" name="password" required autocomplete="new-password" placeholder="Ingresa tu contraseña">

                        <!-- Icon -->
                        <span class="input-group-text">
                            <i class="fe fe-eye"></i>
                        </span>

                    </div>

                </div>

                <div class="form-group">

                    <div class="row">
                        <div class="col">

                            <!-- Label -->
                            <label class="form-label">
                                {{ __('Confirm Password') }}
                            </label>

                        </div>

                    </div> <!-- / .row -->

                    <!-- Password repeat -->
                    <div class="form-group">
                        
                        <!-- Input -->
                        <input id="password_confirmation" type="password" name="password_confirmation" required autofocus autocomplete="new-password" placeholder="Repetir contraseña" class="form-control">

                    </div>
                </div>

                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mt-4">
                        <x-jet-label for="terms">
                            <div class="flex items-center">
                                <x-jet-checkbox name="terms" id="terms"/>

                                <div class="ml-2">
                                    {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Terms of Service').'</a>',
                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900">'.__('Privacy Policy').'</a>',
                                    ]) !!}
                                </div>
                            </div>
                        </x-jet-label>
                    </div>
                @endif

                <x-jet-validation-errors class="mb-4" />

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Submit -->
                <button class="btn btn-lg w-100 btn-primary mb-3">
                    {{ __('Register') }}
                </button>

                <p class="text-center">
                <small class="text-muted text-center">
                    {{ __('¿Ya estás registrado?') }} <a href="{{ route('login') }}">Ingresa aquí</a>.
                </small>
                </p>

            </form>
        </div>
        <div class="col-12 col-md-7 col-lg-6 col-xl-8 d-none d-lg-block">

          <!-- Image -->
          <div class="bg-cover h-100 min-vh-100 mt-n1 me-n3" style="background-image: url({{ asset('assetslogin/img/covers/auth-side-cover.jpg') }});"></div>

        </div>
      </div> <!-- / .row -->
    </div>
</x-guest-layout>