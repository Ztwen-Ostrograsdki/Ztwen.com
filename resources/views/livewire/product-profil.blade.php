<div class="col-xxl-7 col-xl-7 col-11 mx-auto" style="position: relative; top: 100px; margin-bottom: 100px !important">
    <div class="zw-85 mx-auto">
        @include("livewire.components.product.product-profil-component", [
            'product' => $product
        ])
    </div>
    <div class="zw-85 mx-auto p-0 border shadow mb-2 p-2 mb-2">
        <div class="d-flex justify-content-between w-100">
            <h6 class="w-100 py-2 px-2 z-bg-hover-secondary border d-flex justify-content-between">
                <span>
                    <span>Les commentaires</span>
                </span> 
                <span>
                    <span wire:click="addNewComment" class="border border-white cursor-pointer text-dark rounded px-1 mb-1 bg-orange">
                        <span class="d-none d-lg-inline d-xl-inline d-md-inline">Poster un commentaire</span>
                        <span class="fa bi-pen"></span>
                    </span>
                </span>
            </h6>
            
        </div>
        <hr class="m-0 p-0 bg-dark">
        <div class="py-1 mx-auto w-100" style="max-height: 280px; overflow: auto">
            @livewire('product-comments-lister', ['comments' => $comments])
        </div>
    </div>
</div>