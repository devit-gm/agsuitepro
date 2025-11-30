<div class="productos-grid">

    @foreach($familias as $familia)
        <div class="producto-card">
            <a href="{{ fichaRoute('productos', [$ficha->uuid, $familia->uuid]) }}">
                <img src="{{ cachedImage($familia->imagen) }}" 
                     class="img-fluid rounded" 
                     alt="{{ $familia->nombre }}"
                     loading="lazy"
                     decoding="async">
            </a>
        </div>
    @endforeach
</div>