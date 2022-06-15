<div class="w-100 mx-auto my-1" style="position: absolute; top: 100px;">
    <div class="zw-85 mx-auto">
        @include("livewire.components.product.product-profil-component", [
            'product' => $product
        ])
    </div>
    <div class="zw-85 mx-auto p-0 border shadow mb-2 p-2 mb-2">
        <div class="d-flex justify-content-between">
            <h4 class="py-1"> <span class="fa fa-comment-o"></span> Les commentaires </h4>
            <span wire:click="addNewComment" class="btn btn-primary border border-white mb-1">
                <span class="d-none d-lg-inline d-xl-inline d-md-inline">Poster un commentaire</span>
                <span class="fa bi-pen"></span>
            </span>
        </div>
        <hr class="m-0 p-0 bg-dark">
        <div class="py-1 mx-auto w-100" style="max-height: 280px; overflow: auto">
            @livewire('product-comments-lister')
        </div>
    </div>
</div>