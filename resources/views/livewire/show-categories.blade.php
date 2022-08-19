<div class="w-100 mx-auto" style="position: relative; top: 100px; margin-bottom: 100px !important">
    <div class="zw-90 mx-auto">
        <div class="w-100 mx-auto m-0 p-0">
            <div class="m-0 p-0 w-100 pb-3 mx-auto">
                <form  class="d-flex bg-transparent w-100 mx-auto" role="search">
                    <input wire:model="search" class=" form-control border border-secondary me-2 bg-transparent" type="search" placeholder="Chercher un article ou une catégorie..." aria-label="Search">
                    <button class="btn btn-outline-success z-bg-secondary z-border-orange z-text-orange" type="submit">Chercher</button>
                </form>
                @if($search && strlen($search) > 2)
                    <div class="w-75 mx-auto mt-1">
                        <small class="text-dark">{{$categories->count()}} résultat(s) trouvés</small>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-11 mx-auto">
        @if(count($categories) > 0)
            <div class="col-md-12 mb-3">
                <div class="filters-content">
                    <div class="row grid">
                        @foreach($categories as $category)
                            <div class="col-lg-3 col-md-3 all des ">
                                <div class="product-item shadow">
                                    <a href="{{route('category.profil', ['slug' => $category->getSlug()])}}">
                                        <img class="" src="{{$category->__profil()}}" alt="image de la catégorie {{$category->name}}">
                                    </a>
                                        <div class="down-content mx-auto px-lg-1">
                                            <div class="">
                                                <h4 class="w-100" title="{{$category->name}}">
                                                    <strong>{{ mb_strlen($category->name) > 19 ? (mb_substr($category->name, 0, 20) . '...' ) : $category->name}} </strong>
                                                    @auth
                                                        @isMaster()
                                                            <strong wire:click="editACategory({{$category->id}})" title="Editer cette catégorie" class="cursor-pointer fa fa-edit mt-1 text-dark float-right"></strong>
                                                        @endisMaster
                                                    @endauth
                                                </h4>
                                            </div>
                                            <p class="px-1">
                                                {{$category->description}}
                                            </p>
                                            <div class="row w-100 mx-auto">
                                                <div class=" d-flex cursor-pointer justify-content-center col-12 mx-auto p-0">
                                                    <div class="p-0 m-0 w-100">
                                                        <x-dropdown align="right" width="48" class="text-bold m-0 w-75 p-0 bg-secondary border">
                                                            <x-slot name="trigger">
                                                                <x-responsive-nav-link class="text-white-50 cursor-pointer border z-bg-hover-secondary rounded p-0 px-2 py-2 m-0">
                                                                        @if ($category->products->count() > 0)
                                                                            @if ($category->products->count() == 1)
                                                                                0{{ $category->products->count() }} article
                                                                            @elseif ($category->products->count() < 10)
                                                                                0{{ $category->products->count() }} articles
                                                                            @else
                                                                                {{ $category->products->count() }} articles
                                                                            @endif
                                                                        @else
                                                                        Aucun article posté
                                                                        @endif
                                                                    <strong class="fa fa-chevron-down float-right mt-1"></strong>
                                                                </x-responsive-nav-link>
                                                            </x-slot>
                                                            <x-slot name="content" :class="'text-left p-0 m-0'">
                                                                @if ($category->products->count() > 0)
                                                                    @foreach ($category->products as $p)
                                                                        <x-dropdown-link class="nav-item text-left z-a w-100 p-0 m-0 z-hover-secondary text-bold"  href="{{route('product.profil', ['slug' => $p->slug])}}">
                                                                            {{ mb_substr($p->getName(), 0, 14) }}
                                                                        </x-dropdown-link>
                                                                    @endforeach
                                                                @else
                                                                    <x-dropdown-link class="nav-item text-left w-100 p-0 m-0 z-hover-secondary text-bold" href="#">
                                                                        <span class="fa  mr-3"></span>Aucun article
                                                                    </x-dropdown-link>
                                                                @endif
                                                            </x-slot>
                                                        </x-dropdown>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($categories->hasMorePages())
                        <div class="w-100 mx-auto d-flex justify-center my-2 mb-3">
                            <span  wire:click="loadMoreCategories({{$categories->lastPage()}})" class="py-2 px-3 text-white cursor-pointer zw-65 text-center d-inline-block z-bg-secondary-light-opac border border-white rounded">
                                <span class="d-none d-xxl-inline d-lg-inline d-xl-inline d-md-inline">Charger </span> Plus de catégories...
                                <span class="fa fa-arrow-right ml-2"></span>
                            </span>
                        </div>
                    @elseif($categories->total() > $perPage && !$categories->hasMorePages())
                        <div class="w-100 mx-auto d-flex justify-center my-2 mb-3">
                            <span  wire:click="loadLessCategories({{$categories->lastPage()}})" class="py-2 px-3 text-white cursor-pointer zw-65 text-center d-inline-block z-bg-secondary-light-opac border border-white rounded">
                                <span class="fa fa-arrow-left mr-2"></span>
                                Revenir en arrière...
                            </span>
                        </div>
                    @endif
                </div>
            </div>
            @else
            <div class="d-flex flex-column mx-auto text-center border col-10 rounded shadow p-3 my-2">
                <span class="fa fa-warning text-orange fa-2x"></span>
                <h5 class="text-orange">Ouups aucune catéogie trouvée !!!</h5>
            </div>
            @endif
        </div>
</div>