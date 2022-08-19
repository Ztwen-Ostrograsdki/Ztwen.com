<div class="" style="height: 580px; overflow: auto">
    @if ($tag == 'users')
        @include('livewire.components.admin.theUsers', 
        [
        'users' => $users
        ])
    @elseif ($tag == 'unconfirmed')
        @include('livewire.components.admin.unconfirmed', 
            [
            'unconfirmed' => $unconfirmed
            ])
    @elseif ($tag == 'admins')
        @include('livewire.components.admin.theAdmins', 
            [
            'admins' => $admins
            ])
    @elseif ($tag == "categories")
    @include('livewire.components.admin.theCategories', 
    [
       'categories' => $categories
    ])
    @elseif ($tag == "products")
    @include('livewire.components.admin.theProducts', 
    [
       'products' => $products,
       'carts' => $carts,
    ])
    @elseif ($tag == "comments")
    @livewire('comments-lister', 
        [
            'page' => $page,
            'perPage' => $commentsPerPage,
        ]
    )
    @endif
    @if($adminActiveData->total() > 0)
        <form x-show="selector" x-transition class="w-100 mx-auto" wire:submit.prevent="submitSelecteds">
            <div class="w-100 d-flex justify-content-between my-2 mb-3">
                <strong  class="py-1 px-3 text-white-50 cursor-pointer col-3 text-center d-inline-block bg-orange border border-white rounded">
                    <span class="d-none d-xxl-inline d-lg-inline d-xl-inline d-md-inline"> {{count($selecteds)}} éléments sélectionnés</span>
                </strong>
                <div class="col-7 d-flex justify-content-between">
                    <strong x-on:click="@this.call('resetCheckeds')"  class="py-1 px-2 text-dark cursor-pointer text-center d-inline-block bg-success border border-white rounded">
                        <span class="fa fa-recycle"></span>
                    </strong>
                    <button wire:click="setAction('forceDeleteMass')"  class="py-1 px-2 text-dark cursor-pointer text-center d-inline-block bg-danger border border-white rounded">
                        <span class="d-none d-xxl-inline d-lg-inline d-xl-inline d-md-inline"> Supprimer</span>
                        <span class="fa fa-trash ml-2"></span>
                    </button>
                    <button wire:click="setAction('deleteMass')"  class="py-1 px-1 text-dark cursor-pointer text-center d-inline-block bg-info border border-white rounded">
                        <span class="d-none d-xxl-inline d-lg-inline d-xl-inline d-md-inline"> Corbeille</span>
                        <span class="fa fa-trash ml-2"></span>
                    </button>
                    <button wire:click="setAction('resetGaleryMass')"  class="py-1 px-1 text-dark cursor-pointer text-center d-inline-block bg-secondary border border-white rounded">
                        <span class="d-none d-xxl-inline d-lg-inline d-xl-inline d-md-inline"> Retirer images</span>
                        <span class="fa fa-trash ml-2"></span>
                    </button>
                    <button wire:click="setAction('resetBasketMass')"  class="py-1 px-1 text-dark cursor-pointer text-center d-inline-block bg-primary border border-white rounded">
                        <span class="d-none d-xxl-inline d-lg-inline d-xl-inline d-md-inline">Rafraichir demandes</span>
                        <span class="fa fa-trash ml-2"></span>
                    </button>
                </div>
            </div>
        </form>
    @endif
    @if($adminActiveData->lastPage() > 1)
        <div class="d-flex justify-content-between w-100">
            @if ($adminActiveData->currentPage() > 1)
                <div class="col-4 d-flex justify-content-start my-2 mb-3">
                    <span class="py-1 px-3 text-white cursor-pointer w-100 text-center d-inline-block z-bg-secondary-light-opac border border-white rounded" 
                    x-on:click="@this.call('loadPrevPage');">
                        <span class="fa fa-arrow-left mr-2"></span>
                        <span class="d-none d-xxl-inline d-lg-inline d-xl-inline d-md-inline">Page précédente</span>
                    </span>
                </div>
                @else
                <div class="col-4 d-flex justify-content-start my-2 mb-3">
                    <span  class="py-1 px-3 text-white-50 cursor-pointer w-100 text-center d-inline-block z-bg-secondary border border-white rounded">
                        <span class="d-none d-xxl-inline d-lg-inline d-xl-inline d-md-inline"> C'est la dernière page </span>
                        <span class="fa fa-arrow-down ml-2"></span>
                    </span>
                </div>
            @endif
            <div class="col-3 d-flex justify-content-start my-2 mb-3">
                <span class="py-1 px-3 text-dark cursor-pointer w-100 text-center d-inline-block bg-secondary border border-white rounded">
                    <span class="d-none d-xxl-inline d-lg-inline d-xl-inline d-md-inline">Page {{$adminActiveData->currentPage()}} Sur {{$adminActiveData->lastPage()}} </span>
                </span>
            </div>
            @if ($adminActiveData->currentPage() < $adminActiveData->lastPage())
                <div class="col-4 d-flex justify-content-start my-2 mb-3">
                    <span class="py-1 px-3 text-white cursor-pointer w-100 text-center d-inline-block z-bg-secondary-light-opac border border-white rounded"
                    x-on:click="@this.call('loadNextPage');">
                        <span class="d-none d-xxl-inline d-lg-inline d-xl-inline d-md-inline">Page suivante </span>
                        <span class="fa fa-arrow-right ml-2"></span>
                    </span>
                </div>
            @else
                <div class="col-4 d-flex justify-content-start my-2 mb-3">
                    <span  class="py-1 px-3 text-white-50 cursor-pointer w-100 text-center d-inline-block z-bg-secondary border border-white rounded">
                        <span class="d-none d-xxl-inline d-lg-inline d-xl-inline d-md-inline"> C'est la dernière page </span>
                        <span class="fa fa-arrow-down ml-2"></span>
                    </span>
                </div>
            @endif
        </div>
    @endif
</div>