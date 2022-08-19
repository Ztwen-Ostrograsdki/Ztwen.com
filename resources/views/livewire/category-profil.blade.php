<div class="w-100 mx-auto" style="position: relative; top: 100px; margin-bottom: 100px !important">
    <div class="zw-85 mx-auto">
        <div class="row justify-between w-100">
            <div class="col-xxl-7 col-xl-7 col-lg-7 col-12 mb-2">
                <div class="d-flex">
                    <h5>Catégorie </h5> 
                    <h6 class="ml-2 mt-1"> : {{$category->name}}</h6>
                </div>
                <div class="z-bg-secondary-light-opac border border-white rounded col-12 shadow p-2">
                    <h6 class="border-bottom w-100 mb-1 border-white text-white">Description : </h6>
                    <p class="w-100 m-0 bg-transparent text-white-50">
                        {{$category->description}}
                    </p>
                </div>
                <div class="d-flex justify-content-start col-12 p-0">
                    @auth
                        @isMaster()
                            <span wire:click="editCategory" title="Editer cette catégorie" class="py-2 px-1 text-white cursor-pointer zw-20 opacity-75 mt-2 text-center d-inline-block z-bg-secondary-light-opac border border-white rounded">
                                Editer
                                <strong  class="cursor-pointer fa fa-edit mt-1 text-white"></strong>
                            </span>
                            <span wire:click="editCategoryGalery" title="Editer la galerie" class="py-2 px-1 text-white cursor-pointer zw-20 opacity-75 mt-2 text-center d-inline-block z-bg-secondary-light-opac border border-white rounded">
                                Editer
                                <strong class="cursor-pointer fa fa-image mt-1 text-white"></strong>
                            </span>
                        @endisMaster
                    @endauth
                </div>
                <div class="col-12 p-0 my-1">
                    @if ($on_search)
                        <form  class="d-flex bg-transparent w-100 mx-auto" role="search">
                            <input wire:model="search" class=" form-control border border-secondary me-2 bg-transparent col-10" type="search" placeholder="Chercher un article dans cette catégorie..." aria-label="Search">
                            <span wire:click="toggleSearchBar('hide')" class="btn btn-outline-success z-bg-secondary z-border-orange z-text-orange">Masquer</span>
                        </form>
                        @if($search && strlen($search) > 2)
                            <div class="w-75 mx-auto mt-1">
                                <small class="text-dark">{{$products->count()}} résultat(s) trouvés</small>
                            </div>
                        @endif
                    @else
                        <div class="d-flex bg-transparent w-100 mx-auto my-1">
                            <span wire:click="toggleSearchBar('show')" class="btn btn-outline-success z-bg-secondary cursor-pointer z-border-orange z-text-orange">
                                Effectuer une recherche rapide dans cette catégorie
                            </span>
                        </div>
                    @endif
                    
                </div>
            </div>
    
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-12 border p-0">
                <div id="categoryProfilImagesCarouselFalse" class="carousel slide m-0" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach ($category->getImagesOfSize() as $key => $image)
                            <li data-target="#categoryProfilImagesCarouselFalse" data-slide-to="{{$key}}" class="@if($key == 0)active @endif"></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner border w-100 h-100">
                        @foreach ($category->getImagesOfSize() as $key => $image)
                            <div class="carousel-item @if($key == 0)active @endif">
                                <img width="" class="w-100" src="{{$image}}" alt="slide-{{$key}}">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#categoryProfilImagesCarouselFalse" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#categoryProfilImagesCarouselFalse" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="mt-2">
            @if($category->hasProducts())
                <div class="d-flex justify-center col-12 m-0 mx-auto p-0 mb-2">
                    <span class="py-2 px-3 d-flex justify-content-between text-white cursor-pointer w-100 opacity-75 mt-2 text-center d-inline-block z-bg-secondary-light-opac border border-white rounded">
                        <span>
                            <span class="fa fa-tags mr-2"></span>
                            Les articles disponibles
                        </span>
                        <span>
                            {{$category->hasProducts() ? $category->products->count() . ' article(s).' : ' Aucun article'}}
                        </span>
                    </span>
                </div>
                <div class="row grid m-0 p-0">
                    @include('livewire.components.product.product-listing-component', [
                        'products' => $products,
                        'col' => '4',
                    ])
                </div>
            @else
                <div class="d-flex flex-column mx-auto text-center border border-danger p-3 my-2">
                    <span class="fa fa-warning text-danger fa-4x"></span>
                    <h4 class="text-danger fa fa-2x">Ouups aucun article n'a encore été posté !!!</h4>
                </div>
            @endif
        </div>
    </div>
</div>