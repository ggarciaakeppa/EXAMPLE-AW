@if ($errors->any())
    <div {{ $attributes }}>
        <div class="alert alert-danger" role="alert">
            
            <!-- Heading -->
            <h4 class="alert-heading">{{ __('¡Ups! Algo salió mal.') }}</h4>
    
            <!-- Divider -->
            <hr>
    
            <!-- Text -->
            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
    
          </div>
    </div>
@endif