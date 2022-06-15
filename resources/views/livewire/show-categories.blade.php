<div class="m-0 p-0 w-100" >
    <div class="z-justify-relative-top-80 zw-90 mx-auto">
        <div class="w-100 mx-auto m-0 p-0 mt-3">
            <div class="m-0 p-0 w-100 pb-3">
                <form  class="d-flex mt-3 bg-transparent w-75" role="search">
                    <input wire:model="search" class=" form-control border border-secondary me-2 bg-transparent" type="search" placeholder="Chercher un article ou une catégorie..." aria-label="Search">
                    <button class="btn btn-outline-success z-bg-secondary z-border-orange z-text-orange" type="submit">Search</button>
                </form>
                <main class="" style="z-index:2010;" >
                    <nav class="navbar navbar-dark" >
                        <div class="container-fluid" style="z-index:2010 !important;">
                          <div class="zw-85 d-flex justify-content-start">
                            <button style="left: 0!important" class="navbar-toggler py-2 px-3 pt-3 border z-border-orange z-bg-secondary mr-1 position-relative d-flex" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenuOfCategories" aria-controls="offcanvasMenuOfCategories">
                                <span class="bi-bookmarks z-text-orange mr-2"></span>
                                <h5>Les categories <span class="float-right z-text-orange ml-3">({{$categories->count()}})</span></h5>
                            </button>
                          </div>
                          <div style="" class="offcanvas offcanvas-end text-white bg-dark" tabindex="-1" id="offcanvasMenuOfCategories" aria-labelledby="offcanvasMenuOfCategoriesLabel">
                            <div class="offcanvas-header mt-5">
                              <h5 class="offcanvas-title mt-5" id="offcanvasMenuOfCategoriesLabel">
                                <span class="bi-list-check mr-2"></span> Liste
                              </h5>
                              <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body" style="z-index:30000 !important;" >
                                <span>Plus de {{$productsCounter}} articles disponibles</span>
                                <hr>
                                <ul class="navbar-nav justify-content-end text-white flex-grow-1 pe-3">
                                    @if($categories->count() > 0)
                                        @foreach ($categories as $key => $cat)
                                        <li wire:click="categorySelected({{$cat->id}})" class="nav-item cursor-pointer">
                                            <span class="nav-link text-white-50">
                                                <span class="bi-tag mr-2"></span>
                                                <span>{{ __($cat->name) }}</span>
                                                <span class="float-right">({{$cat->products->count()}})</span>
                                                <span class="sr-only">(current)</span>
                                            </span>
                                        </li>
                                        @endforeach
                                    @else
                                        <li class="nav-item cursor-pointer">
                                            <span class="nav-link text-dark">
                                                <span>Aucun article postés</span>
                                            </span>
                                        </li>
                                    @endif
                                    @auth
                                    <x-z-link :params="['id' => auth()->user()->id]" :route="'user-profil'" :active="request()->routeIs('user-profil')">
                                        <span class="bi-person mr-2"></span>
                                        <span>{{ __('Profil') }}</span>
                                    </x-z-link>
                                    @endauth
                                    @guest
                                    <x-z-link :route="'login'" :active="request()->routeIs('login')">
                                        <span class="bi-person-check mr-2"></span>
                                        <span>{{ __('Se connecter') }}</span>
                                    </x-z-link>
                                    <x-z-link :route="'registration'" :active="request()->routeIs('registration')">
                                        <span class="bi-person-plus mr-2"></span>
                                        <span>{{ __("S'inscrire") }}</span>
                                    </x-z-link>
                                    @endguest
                                    
                                </ul>
                                <form  class="d-flex mt-3" role="search">
                                    <input class="form-control me-2" type="search" placeholder="Chercher un article ou une catégorie..." aria-label="Search">
                                    <button class="btn btn-outline-success" type="submit">Search</button>
                                </form>
                            </div>
                          </div>
                        </div>
                      </nav>
                  </main>
            </div>
            <div class="row w-100 mx-auto justify-content-center mt-1">
                @if ($category && !$search)
                    <div class="z-secondary col-12 m-0 p-0 mx-auto mb-2">
                        <h5 class="d-flex justify-content-between cursor-pointer text-center text-white py-2 m-0 border px-2">
                            <span class="text-center w-100">
                                <span class="float-left ml-1">
                                    <span class="bi-bookmark-check mx-1"></span>
                                    <span class="bi-chevron-right mx-1"></span>
                                    <span>{{$category->name}} </span> 
                                </span>
                                <span class="float-right text-right mr-2">({{$category->products->count()}})</span>
                            @isAdmin()
                                <span wire:click="editACategory({{$category->id}})" title="Editer cette catégorie" class="fa fa-edit text-white-50 float-right mt-1 ml-3 cursor-pointer"></span>
                            @endisAdmin
                            </span>
                        @if($category->products->count() > 0)
                                @isAdmin()
                                    <span wire:click="createNewCategory" data-target="#createProductModal" data-toggle="modal" data-dismiss="modal" class="btn btn-primary border border-white">
                                        <span class="fa fa-plus"></span>
                                        Ajouter un article
                                    </span>
                                @endisAdmin
                        @else
                                <span class="btn btn-info border border-warning">
                                    Aucun article enregistré
                                </span>
                        @endif
                        </h5>
                    
                    </div>
                @endif
                <div class="col-12" >
                    <div class="col-12 p-2" style="max-height: 700px; overflow: auto">
                        @if ($search)
                            <ul class="navbar-nav justify-content-end text-white flex-grow-1 pe-3">
                                @if($targets)
                                    @if ($targets['products'])
                                        <h6 class="text-dark">Plus de {{$targets['products']->count()}} articles trouvés</h6>
                                        @foreach ($targets['products'] as $key => $t_p)
                                        <div class="cursor-pointer pb-1 row justify-between text-white-50 z-bg-secondary border mb-1">
                                            <div class="p-0 m-0">
                                                <a class="w-100" href="{{route('product-profil', ['id' => $t_p->id])}}">
                                                    <img width="100%" class="border w-100" src="{{$t_p->getRandomDefaultImage()}}" alt="">
                                                </a>
                                            </div>
                                            <div class="">
                                                <span>
                                                    Article: <span>{{$t_p->getName()}}</span>
                                                </span>
                                                <span>
                                                    Description: <span>{{mb_substr($t_p->description, 0, 50)}}</span>
                                                </span>
                                                <span class="d-flex justify-between">
                                                    <span>Prix : <strong>{{$t_p->price}} FCFA</strong></span> 
                                                    <span>Total : <strong>{{$t_p->total}} </strong></span> 
                                                </span>
                                                <span>
                                                    Posté : <span>{{$t_p->getDateAgoFormated()}}</span>
                                                </span>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="border-bottom">
                                            <h5 class="nav-link text-dark">
                                                <span>Aucun article trouvés</span>
                                            </h5>
                                        </div>
                                    @endif
                                    @if ($targets['categories'])
                                        <h6 class="text-dark">Plus de {{$targets['categories']->count()}} catégories trouvées</h6>
                                        @foreach ($targets['categories'] as $key => $t_c)
                                            <li wire:click="categorySelected({{$t_c->id}})" class="nav-item cursor-pointer text-dark">
                                                <h5>
                                                    <span class="bi-tag mr-2"></span>
                                                    <span>{{ $t_c->name }}</span>
                                                </h5>
                                                <h6>Plus de {{$t_c->products->count()}} articles disponibles dans cette catégorie</h6>
                                            </li>
                                            <hr>
                                        @endforeach
                                    @else
                                        <li class="nav-item cursor-pointer">
                                            <span class="nav-link text-dark">
                                                <span>Aucune catégorie trouvée</span>
                                                <span class="sr-only">(current)</span>
                                            </span>
                                        </li>
                                    @endif
                                @else
                                    <li class="nav-item cursor-pointer">
                                        <span class="nav-link text-white-50">
                                            <span>Aucun éléments correspondants à ''{{$search}}'' trouvés</span>
                                            <span class="sr-only">(current)</span>
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        @else
                            @if($category)


                                @if($category->products->count() > 0)
                                    <div class="zw-85 mx-auto my-1">
                                        @foreach ($products as $p)
                                            @include("livewire.components.product.product-profil-component", [
                                                'product' => $p
                                            ])
                                        @endforeach
                                    </div>
                                @else
                                    <div class="w-100 mx-auto my-1 bg-info border d-flex flex-column justify-content-center">
                                        <h3 class="text-warning p-2 text-center">
                                            <span class="fa fa-warning mr-2"></span>
                                            Oooups!!! Cette catégorie n'a pas encore d'articles enregistrés!
                                        </h3>
                                        @isAdmin()
                                            <div class="mx-auto my-2 w-100 d-flex justify-content-center">
                                                <span wire:click="createNewCategory" data-target="#createProductModal" data-toggle="modal" data-dismiss="modal" class="btn btn-primary border border-white">
                                                    <span class="fa fa-plus"></span>
                                                    Ajouter un article
                                                </span>
                                            </div>
                                        @endisAdmin
                                    </div>
                                @endif
                            @else
                                <h4 class="cursor-pointer z-secondary text-center text-white py-2 border border-bottom px-2">
                                    <span> Selectionnez une catégorie </span>
                                </h4>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>