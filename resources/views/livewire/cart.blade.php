<div>
    <div class="col-md-12">
        <div class="filters-content">
            <div class="row grid">
                @foreach ($products as $p)
                <div class="mx-auto p-0 mb-2 col-xxl-8 col-xl-10 col-lg-10 col-md-12 col-12">
                    @include("livewire.components.product.product-profil-component", [
                        'product' => $p
                    ])
                </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
