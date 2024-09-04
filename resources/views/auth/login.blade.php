<!-- CONTENT ================================================== -->
<x-guest-layout>
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-12 col-md-5 col-lg-6 col-xl-4 px-lg-6 my-5 align-self-center">

          <!-- Heading -->
          <h1 class="display-4 text-center mb-3">
            Inicio sesión
          </h1>

          <!-- Subheading -->
          <p class="text-muted text-center mb-5">
            Bienvenido a {{ config('app.name', 'Laravel') }}
          </p>

          <!-- Form -->
          <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email address -->
            <div class="form-group">

              <!-- Label -->
              <label class="form-label">
                Correo electrónico
              </label>

              <!-- Input -->
              <input id="email" type="email" name="email" :value="old('email')" required autofocus placeholder="nombre@dominio.com" class="form-control">

            </div>

            <!-- Password -->
            <div class="form-group">
              <div class="row">
                <div class="col">

                  <!-- Label -->
                  <label class="form-label">
                    Contraseña
                  </label>

                </div>
                <div class="col-auto">

                  <!-- Help text -->
                  @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="form-text small text-muted">
                      ¿Olvidaste tu contraseña?
                    </a>
                  @endif

                </div>
              </div> <!-- / .row -->

              <!-- Input group -->
              <div class="input-group input-group-merge">

                <!-- Input -->
                <input class="form-control" type="password" id="password" name="password" required autocomplete="current-password" placeholder="Ingresa tu contraseña">

                <!-- Icon -->
                <span class="input-group-text">
                  <i class="fe fe-eye"></i>
                </span>

              </div>

              <div class="block mt-4">
                  <label for="remember_me" class="flex items-center">
                      <x-jet-checkbox id="remember_me" name="remember" />
                      <span class="ml-2 text-sm text-gray-600">{{ __('Recuerdame') }}</span>
                  </label>
              </div>

            </div>

            <x-jet-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Submit -->
            <button class="btn btn-lg w-100 btn-primary mb-3">
              Ingresar
            </button>

            <p class="text-center">
              <small class="text-muted text-center">
                ¿Aun no tienes usuario? <a href="{{ route('register') }}">Registra aquí</a>.
              </small>
            </p>

          </form>

        </div>
        <div class="col-12 col-md-7 col-lg-6 col-xl-8 d-none d-lg-block">

          <!-- Image -->
          <div class="bg-cover h-100 min-vh-100 mt-n1 me-n3" style="background-image: url({{ asset('assets/img/covers/auth-side-cover.jpg') }});"></div>

        </div>
      </div> <!-- / .row -->
    </div>
</x-guest-layout>