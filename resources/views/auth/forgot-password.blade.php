<x-guest-layout>
    <!-- CONTENT
    ================================================== -->
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-12 col-md-5 col-lg-6 col-xl-4 px-lg-6 my-5 align-self-center">

          <!-- Heading -->
          <h1 class="display-4 text-center mb-3">
          Restablecimiento de contraseña
          </h1>

          <!-- Subheading -->
          <p class="text-muted text-center mb-5">
            Ingrese su correo electrónico para obtener un enlace para restablecer la contraseña.
          </p>

          <!-- Form -->
          <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email address -->
            <div class="form-group">

              <!-- Label -->
              <label class="form-label">
                Dirección de correo electrónico
              </label>

              <!-- Input -->
              <input type="email" class="form-control" placeholder="nombre@dominio.com" id="email" name="email" :value="old('email')" required autofocus>

            </div>

            <x-jet-validation-errors class="mb-4" />

            @if (session('status'))
              <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Submit -->
            <button class="btn btn-lg w-100 btn-primary mb-3">
              {{ __('Enviar correo para restablecer contraseña') }}
            </button>

            <!-- Link -->
            <div class="text-center">
              <small class="text-muted text-center">
              ¿Recuerdas tu contraseña? <a href="{{ route('login') }}">Ingresa</a>.
              </small>
            </div>

          </form>

        </div>
        <div class="col-12 col-md-7 col-lg-6 col-xl-8 d-none d-lg-block">

          <!-- Image -->
          <div class="bg-cover h-100 min-vh-100 mt-n1 me-n3" style="background-image: url({{ asset('assets/img/covers/auth-side-cover.jpg') }})"></div>

        </div>
      </div> <!-- / .row -->
    </div>
</x-guest-layout>
