@props(['id' => null, 'maxWidth' => null])

<x-jet-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="modal-card card">
        <div class="card-header">
            <h4 class="card-header-title">
                {{ $title }}
            </h4>
        </div>

        <div class="card-body">
            {{ $content }}
        </div>

        <div class="modal-footer bg-light">
            {{ $footer }}
        </div>
    </div>
</x-jet-modal>
