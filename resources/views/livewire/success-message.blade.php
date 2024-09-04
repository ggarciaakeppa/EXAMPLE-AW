<div class="row align-items-center">
    <div class="col">
        <x-jet-validation-errors class="mb-4" />

        @if (session()->has('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
    </div>
</div>