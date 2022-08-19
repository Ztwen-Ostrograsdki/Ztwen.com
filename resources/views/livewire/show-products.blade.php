<div class="m-0 p-0">
    @if(count($products) > 0)
        <div class="col-xxl-9 col-xl-9 col-lg-9 col-11 mx-auto p-0">
            @include('livewire.components.product.product-listing-component', [
            'products' => $products,
            'col' => '4',
        ])
        </div>
        @if(!$onHome)
            @if($products->hasMorePages())
                @livewire('load-more-products', ['page' => $page, 'perPage' => $perPage, 'key' => 'products-page-' . $page])
            @endif
        @endif
    @else
        <div class="d-flex col-xxl-9 col-xl-9 col-lg-9 col-11 flex-column mx-auto text-center p-3 my-2">
            <span class="fa fa-warning text-danger fa-3x"></span>
            <h5 class="text-danger fa-1x">Ouups aucun article n'a encore été posté !!!</h5>
        </div>
    @endif
</div>