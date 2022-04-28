<div>
    <div class="page-heading products-heading header-text">
        <div class="container">
        <div class="row">
            <div class="col-md-12">
            <div class="text-content">
                <h4>nouvel arrivage</h4>
                <h2>Les articles à la une</h2> 
            </div>
            </div>
        </div>
        </div>
    </div>
        <div class="products">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="mx-auto w-100 d-flex justify-content-center">
                        <select wire:change="changeEvent" wire:model="categorySelected" class="bg-info form-select-lg text-white py-2" name="categories" id="categories">
                            <option class="text-dark" value="">Selectionner la catégorie à afficher</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->name}}">
                                    {{$category->name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            
                <div class="col-md-12">
                    <div class="filters">
                    <ul>
                        @if ($categorySelected)
                            <li class="@if(session()->has('sectionSelected') && session('sectionSelected') == 'allPosted') active @endif" data-filter="*"> 
                                <span class="text-dark">Catégorie listée</span> : {{$categorySelected}} 
                                @if(count($allProducts) > 9)
                                    <span>({{count($allProducts)}})</span>
                                @else
                                    <span>(0{{count($allProducts)}})</span>
                                @endif
                            </li> 
                        @else
                            <li wire:click="changeSection('allPosted')" class="@if(session()->has('sectionSelected') && session('sectionSelected') == 'allPosted') active @endif" data-filter="*">Tous les articles 
                                @if(count($allProducts) > 9)
                                    <span>({{count($allProducts)}})</span>
                                @else
                                    <span>(0{{count($allProducts)}})</span>
                                @endif
                            </li>
                        @endif
                        <li class="@if(session()->has('sectionSelected') && session('sectionSelected') == 'lastPosted') active @endif" wire:click="lastPosted" data-filter=".des">Les plus récents</li>
                        <li class="@if(session()->has('sectionSelected') && session('sectionSelected') == 'mostSeen') active @endif" wire:click="mostSeen" data-filter=".gras">Les plus visités</li>
                        <li data-filter=".dev">Flash trocs</li>
                    </ul>
                    </div>
                </div>
                @if($allProducts->count() > 0)
                <div class="col-md-12">
                    <div class="filters-content">
                        <div class="row grid">
                            @foreach($products as $product)
                                <div class="col-lg-4 col-md-4 all des ">
                                    <div class="product-item @if(Auth::user() && Auth::user()->alreadyIntoCart($product->id)) shadow @endif">
                                        <a wire:click="setTargetedProduct({{$product->id}})" title="Cliquez pour charger l'article {{ $product->slug }}" href="{{route('product-profil', ['id' => $product->id])}}">
                                            @if($product->images->count() > 0)
                                                <img class="z-img-h-250" src="/storage/articlesImages/{{$product->getProductDefaultImageInGalery()}}" alt="image de l'article {{$product->slug}}">
                                            @else
                                                <img class="z-img-h-250" src="{{$product->getRandomDefaultImage()}}" alt="image de l'article {{$product->slug}}">
                                            @endif
                                        </a>
                                            <div class="down-content mx-auto px-lg-1">
                                                <a ><h4>{{mb_substr($product->slug, 0, 15)}} ...</h4></a>
                                                <h6>{{$product->price}}
                                                    @auth
                                                        @if(Auth::user()->alreadyIntoCart($product->id))
                                                            <strong title="Vous suivez cet article: Vous l'avez ajouté à votre panier" class="text-success bi-cart-check-fill cursor-pointer"></strong>
                                                        @endif
                                                    @endauth
                                                </h6>
                                                <p class="px-1">
                                                    {{$product->description}}
                                                </p>
                                                <div class="d-flex justify-content-betwween w-100 m-0 p-0 mx-auto">
                                                    <ul class="col-lg-5 col-xl-5 d-xl-inline-block d-lg-inline-block d-none">
                                                        <li><i class="fa fa-star"></i></li>
                                                        <li><i class="fa fa-star"></i></li>
                                                        <li><i class="fa fa-star"></i></li>
                                                        <li><i class="fa fa-star"></i></li>
                                                        <li><i class="fa fa-star"></i></li>
                                                    </ul>
                                                    <div class="m-0 p-0 col-lg-7 col-xl-7 px-xl-2 pr-xl-2 px-lg-2 pr-lg-2 col-12">
                                                        <div class="m-0 p-0 d-flex justify-content-lg-end justify-content-xl-end justify-content-center w-100 text-danger">
                                                            <strong>
                                                                <strong class="mt-1"> {{$product->likes->count()}} </strong>
                                                                <strong class="fa fa-heart mt-1"></strong>
                                                            </strong>
                                                            <strong class="mx-3">
                                                                <strong class="mt-1"> {{$allProductsComments[$product->id]->count()}} </strong>
                                                                <strong class="fa fa-comments mt-1"></strong>
                                                            </strong>
                                                            <strong class="">
                                                                @if($targetedProduct && $targetedProductSeens && $targetedProduct->id == $product->id)
                                                                    <strong class="mt-1"> {{$targetedProductSeens}} </strong>
                                                                @else
                                                                    <strong class="mt-1"> {{$product->mySeens()}} </strong>
                                                                @endif
                                                                <strong class="fa fa-eye mt-1"></strong>
                                                            </strong>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row w-100 mx-auto">
                                                    <div class="d-flex cursor-pointer justify-content-center col-lg-4 col-xl-4 col-12 mx-auto">
                                                        <strong wire:click="liked({{ $product->id }})" title="Cliquez pour liker cet article" class="fa fa-heart z-scale text-danger fa-2x"></strong>
                                                    </div>
                                                    <div class=" d-flex cursor-pointer justify-content-center mt-lg-2 mt-xl-2 mt-3 col-lg-7 col-xl-7 col-12 mx-auto p-0">
                                                        <div class="d-flex justify-content-around p-0 m-0 w-100">
                                                            <a style="width: 45%" href="{{route('product-profil', ['id' => $product->id])}}" class="z-scale text-danger text-center">
                                                                <i class="btn-primary py-1 pb-2 px-lg-1 px-xl-1 px-md-1 px-4 w-100 border"> 
                                                                    <small class="w-75 mx-auto text-center d-inline-block">
                                                                        <small class="fa fa-chevron-down"></small>
                                                                        <small class="d-xl-inline">Voir plus</small>
                                                                    </small>
                                                                </i>
                                                            </a>
                                                            @auth
                                                                @if(Auth::user()->alreadyIntoCart($product->id))
                                                                    <a wire:click="deleteFromCart({{ $product->id }})" title="Mettre cet article dans mon panier" style="width: 45%" class="z-scale text-danger text-center">
                                                                        <i class="btn-danger py-1 pb-2 px-lg-1 px-xl-1 px-md-1 px-4 w-100 border border-warning"> 
                                                                            <small class="w-75 mx-auto text-center d-inline-block">
                                                                                <small class="fa bi-minecart"></small>
                                                                                <small class="d-xl-inline">Retirer</small>
                                                                            </small>
                                                                        </i>
                                                                    </a>
                                                                @else
                                                                    <a title="Mettre cet article dans mon panier" style="width: 45%" wire:click="addToCart({{ $product->id }})" class="z-scale text-danger text-center">
                                                                        <i class="btn-success py-1 pb-2 px-lg-1 px-xl-1 px-md-1 px-4 w-100 border"> 
                                                                            <small class="w-75 mx-auto text-center d-inline-block">
                                                                                <small class="fa bi-minecart"></small>
                                                                                <small class="d-xl-inline">Panier</small>
                                                                            </small>
                                                                        </i>
                                                                    </a>
                                                                @endif
                                                            @endauth
                                                            @guest
                                                                <a title="Mettre cet article dans mon panier" style="width: 45%" wire:click="addToCart({{ $product->id }})" class="z-scale text-danger text-center">
                                                                    <i class="btn-success py-1 pb-2 px-lg-1 px-xl-1 px-md-1 px-4 w-100 border"> 
                                                                        <small class="w-75 mx-auto text-center d-inline-block">
                                                                            <small class="fa bi-minecart"></small>
                                                                            <small class="d-xl-inline">Panier</small>
                                                                        </small>
                                                                    </i>
                                                                </a>  
                                                            @endguest
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @else
                <div class="d-flex flex-column mx-auto text-center border border-danger p-3 my-2">
                    <span class="fa fa-warning text-danger fa-4x"></span>
                    <h4 class="text-danger fa fa-2x">Ouups aucun article n'a encore été posté !!!</h4>
                </div>
                @endif
                @if($allProducts->count() > 0 && count($pages) > 1)
                <div class="col-md-12 ">
                    <ul class="pages mb-3">
                        @if($minPage > 0)
                            <span>
                                <li wire:click="decreasePage()">
                                <a>
                                    <i class="fa fa-angle-double-left"></i>
                                </a>
                                </li>
                            </span>
                        @endif
                        @foreach ($pages as $page)
                            @if($page + 1 <= $maxPage && $page + 1 > $minPage)
                                <li class="@if($active_page == $page) active @endif cursor-pointer" ><a wire:click="setActivePage({{$page}})" class="" >{{$page + 1}}</a></li>
                            @endif
                        @endforeach
                        @if($maxPage < count($pages))
                            <li wire:click="increasePage()"><a><i class="fa fa-angle-double-right"></i></a></li>
                        @endif
                    </ul>
                </div>
            @endif
            </div>
        </div>
    </div>
</div>