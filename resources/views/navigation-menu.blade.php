
@php 

$showarray = Config::get('theme.var'); 
//($showarray['demoMode']) ? ($showarray['navColor'] == 'default') ? 'navbar-light' : ($showarray['navColor'] == 'inverted') ? 'navbar-dark' : ($showarray['navColor'] == 'vibrant') ? 'navbar-dark navbar-vibrant' : '' : ''

@endphp
<nav class="navbar navbar-vertical fixed-start navbar-expand-md navbar-light" id="sidebar">
  <div class="container-fluid">

    <!-- Toggler -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Brand -->
    <a class="navbar-brand" href="/">
      <img src="/assets/img/logo.svg" class="navbar-brand-img mx-auto" alt="...">
    </a>

    <!-- User (xs) -->
    <div class="navbar-user d-md-none">

      <!-- Dropdown -->
      <div class="dropdown">

        <!-- Toggle -->
        <a href="#" id="sidebarIcon" class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <div class="avatar avatar-sm avatar-online">
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="avatar-img rounded-circle">
            @endif
          </div>
        </a>

        <!-- Menu -->
        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="sidebarIcon">
          <!-- Account Management -->
          <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')" class="dropdown-item">
                    {{ __('Perfil') }}
          </x-jet-responsive-nav-link>

          @if (Laravel\Jetstream\Jetstream::hasApiFeatures())

                <hr class="dropdown-divider">

                <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')" class="dropdown-item">
                    {{ __('API Tokens') }}
                </x-jet-responsive-nav-link>
          @endif

          <hr class="dropdown-divider">
          <!-- Authentication -->
          <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-jet-responsive-nav-link href="{{ route('logout') }}"
                onclick="event.preventDefault();
                    this.closest('form').submit();"
                    class="dropdown-item">
                    {{ __('Desconectar') }}
            </x-jet-responsive-nav-link>
          </form>
        </div>

      </div>

    </div>

    <!-- Collapse -->
    <div class="collapse navbar-collapse" id="sidebarCollapse">

      <!-- Form -->
      <form class="mt-4 mb-3 d-md-none">
        <div class="input-group input-group-rounded input-group-merge input-group-reverse">
          <input class="form-control" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-text">
            <span class="fe fe-search"></span>
          </div>
        </div>
      </form>

      <!-- Navigation -->
      <ul class="navbar-nav">
       
        <li class="nav-item">
          <x-jet-responsive-nav-link class="nav-link" href="/dashboard" :active="request()->routeIs('dashboard')">
          <i class="fe fe-home"></i> Inicio
          </x-jet-responsive-nav-link>
        </li>
       
      </ul>
      @if(auth()->user()->can('ingresos'))
      <ul class="navbar-nav">
        <li class="nav-item">
          @if(Route::is('ingreso.auto.*') )
          <a class="nav-link" href="#ingreso" data-bs-toggle="collapse" role="button" aria-expanded="true" aria-controls="ingreso" :active="request()->routeIs('ingreso.auto.*')">
          @else
          <a class="nav-link" href="#ingreso" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="ingreso" :active="request()->routeIs('ingreso.auto.*')">
          @endif
          <i class="fe fe-users"></i> Ingreso Auto
          </a>
          @if(Route::is('ingreso.*') )
          <div class="collapse show" id="ingreso">
          @else
          <div class="collapse" id="ingreso">
          @endif
            <ul class="nav nav-sm flex-column">
              <li class="nav-item">
                <x-jet-responsive-nav-link href="{{ route('ingreso.auto.index') }}" class="nav-link" :active="request()->routeIs('ingreso.auto.index')">
                  Ingresos
                </x-jet-responsive-nav-link>
              </li>
            </ul>
          </div>
        </li>
      </ul>
      @endif
      @if(auth()->user()->can('usuarios'))
      <!-- Divider -->
      <hr class="navbar-divider my-3">

      <!-- Heading -->
      <h6 class="navbar-heading">
        Administrador
      </h6>

      <ul class="navbar-nav">
        <li class="nav-item">
          @if(Route::is('users.*') )
          <a class="nav-link" href="#users" data-bs-toggle="collapse" role="button" aria-expanded="true" aria-controls="users" :active="request()->routeIs('users.*')">
          @else
          <a class="nav-link" href="#users" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="users" :active="request()->routeIs('users.*')">
          @endif
          <i class="fe fe-users"></i> Usuarios
          </a>
          @if(Route::is('users.*') )
          <div class="collapse show hover" id="users">
          @else
          <div class="collapse" id="users">
          @endif
            <ul class="nav nav-sm flex-column">
              <li class="nav-item">
                <x-jet-responsive-nav-link href="{{ route('users.index') }}" class="nav-link" :active="request()->routeIs('users.index')">
                  Administración
                </x-jet-responsive-nav-link>
              </li>
            </ul>
          </div>
        </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
          @if(Route::is('products.*') )
          <a class="nav-link" href="#users" data-bs-toggle="collapse" role="button" aria-expanded="true" aria-controls="users" :active="request()->routeIs('users.*')">
          @else
          <a class="nav-link" href="#users" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="users" :active="request()->routeIs('users.*')">
          @endif
          <i class="fe fe-users"></i> Productos
          </a>
          @if(Route::is('products.*') )
          <div class="collapse show" id="users">
          @else
          <div class="collapse" id="users">
          @endif
            <ul class="nav nav-sm flex-column">
              <li class="nav-item">
                <x-jet-responsive-nav-link href="{{ route('users.index') }}" class="nav-link" :active="request()->routeIs('users.index')">
                  Administración
                </x-jet-responsive-nav-link>
              </li>
          
            </ul>
          </div>
        </li>
      </ul>

      @endif
      

      <!-- Push content down -->
      <div class="mt-auto"></div>

      @if($showarray['demoMode'])
        <!-- Customize -->
        <div class="mb-4" id="popoverDemo" title="Make Dashkit Your Own!" data-bs-content="Switch the demo to Dark Mode or adjust the navigation layout, icons, and colors!">
          <a class="btn w-100 btn-primary" data-bs-toggle="offcanvas" href="#offcanvasDemo" aria-controls="offcanvasDemo">
            <i class="fe fe-sliders me-2"></i> Customize
          </a>
        </div>
      @endif

      @if($showarray['navPosition'] == 'sidenav')
        <!-- User (md) -->
        <div class="navbar-user d-none d-md-flex" id="sidebarUser">

          <!-- Icon -->
          <!--<a class="navbar-user-link" data-bs-toggle="offcanvas" href="#sidebarOffcanvasActivity" aria-controls="sidebarOffcanvasActivity">
            <span class="icon">
              <i class="fe fe-bell"></i>
            </span>
          </a>-->

          <!-- Dropup -->
          <div class="dropup">

            <!-- Toggle -->
            <a href="#" id="sidebarIconCopy" class="dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <div class="avatar avatar-sm avatar-online">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="avatar-img rounded-circle">
                @else
                    <img src="/assets/img/avatars/profiles/avatar-1.jpg" alt="Domiti profile" class="avatar-img rounded-circle">
                @endif
              </div>
            </a>

            <!-- Menu -->
            <div class="dropdown-menu" aria-labelledby="sidebarIconCopy">
              <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')" class="dropdown-item">Perfil</x-jet-responsive-nav-link>
              <!--<a href="/account-general.html" class="dropdown-item">Settings</a>-->

              @if (Laravel\Jetstream\Jetstream::hasApiFeatures())

                    <hr class="dropdown-divider">

                    <x-jet-responsive-nav-link href="{{ route('api-tokens.index') }}" class="dropdown-item" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-jet-responsive-nav-link>
              @endif

              <hr class="dropdown-divider">

              <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}" class="dropdown-item"
                        onclick="event.preventDefault();
                            this.closest('form').submit();">
                            {{ __('Desconectar') }}
                    </x-jet-responsive-nav-link>
                </form>
            </div>

          </div>

          <!-- Icon -->
          <!--<a class="navbar-user-link" data-bs-toggle="offcanvas" href="#sidebarOffcanvasSearch" aria-controls="sidebarOffcanvasSearch">
            <span class="icon">
              <i class="fe fe-search"></i>
            </span>
          </a>-->

        </div>
        @endif

    </div> <!-- / .navbar-collapse -->

  </div>
</nav>
